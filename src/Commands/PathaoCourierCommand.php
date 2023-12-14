<?php


namespace Enan\PathaoCourier\Commands;


use Enan\PathaoCourier\APIBase\PathaoAuth;
use Enan\PathaoCourier\DataDTO\AccessTokenDTO;
use Enan\PathaoCourier\Requests\PathaoAccessTokenRequest;
use Enan\PathaoCourier\Services\DataServiceOutput;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PathaoCourierCommand extends Command
{
    const TYPE_ASK = 'ask';
    const TYPE_SECRET = 'secret';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:pathao-courier';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will set up your pathao account.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->checkExistingData()) {
            $this->steps();
        } else {
            $this->errorMessage("You have already registered a token");

            if ($this->confirm('Do you wish to continue? It will reset your existing tokens.', false)) {
                $this->steps();
            }
        }
    }

    private function steps()
    {
        $pathao_client_id = config('pathao-courier.pathao_client_id');
        $pathao_client_secret = config('pathao-courier.pathao_client_secret');

        if (!empty($pathao_client_id) && !empty($pathao_client_secret)) {
            $this->newLine(1);
            $this->line('Please provide pathao credentials:');

            $username = $this->askForNonEmptyValue('Username: this should be your email address', self::TYPE_ASK);
            $password = $this->askForNonEmptyValue('Password: we won\'t save this.', self::TYPE_SECRET);
            $grant_type = 'password';

            $access_token_request = new PathaoAccessTokenRequest(
                [
                    "client_id" => $pathao_client_id,
                    "client_secret" => $pathao_client_secret,
                    "username" => $username,
                    "password" => $password,
                    "grant_type" => $grant_type,
                ]
            );

            $cred = (new AccessTokenDTO)->fromRequest($access_token_request);
            $response = $this->GET_ACCESS_TOKEN($cred);

            $this->newLine(1);
            $data = $response->getData();
            if ($response->isSuccess()) {
                $this->successMessage("Your secret uniqe token is " . Arr::get($data, 'secret_token'));
            } else {
                $this->errorMessage(Arr::get($data, 'message'));
            }
            $this->newLine(1);
        } else {
            if (empty($pathao_client_id)) {
                $this->errorMessage('Please provide your patho client id in .env file');
            }
            if (empty($pathao_client_secret)) {
                $this->errorMessage('Please provide your patho client secret in .env file');
            }
        }
    }

    /**
     * It will check if the DB has already one issued token
     * @return bool
     */
    private function checkExistingData(): bool
    {
        $data_exist = DB::table(env('PATHAO_DB_TABLE_NAME'))->count();
        if ($data_exist > 0) {
            return false;
        }
        return true;
    }

    /**
     * It will return a message to command only for success
     * @param string $message
     * @return void
     */
    private function successMessage(string $message)
    {
        $this->newLine(1);
        $this->info($message);
        $this->newLine(2);
    }

    /**
     * It will return a message to command only for error
     * @param string $message
     * @return void
     */
    private function errorMessage(string $message)
    {
        $this->newLine(1);
        $this->error($message);
        $this->newLine(2);
    }

    /**
     * This will keep asking the value if the given input is empty
     * @param mixed $question
     * @param mixed $type
     * @return mixed
     */
    private function askForNonEmptyValue($question, $type)
    {
        $value = '';

        while (empty($value)) {
            if ($type == self::TYPE_ASK) {
                $value = $this->ask($question);
            } else if ($type == self::TYPE_SECRET) {
                $value = $this->secret($question);
            }

            if (empty($value)) {
                $this->error('Value cannot be empty. Please provide a non-empty value.');
            }
        }

        return $value;
    }

    /**
     * This will issue a access token from Pathao Courier
     * @param array $cred
     * @return \Enan\PathaoCourier\Services\DataServiceOutput
     */
    private static function GET_ACCESS_TOKEN(array $cred): DataServiceOutput
    {
        return (new PathaoAuth)->getAccessToken($cred);
    }

    /**
     * This will issue a access token from Pathao Courier
     * @return \Enan\PathaoCourier\Services\DataServiceOutput
     */
    private static function GET_NEW_ACCESS_TOKEN(): DataServiceOutput
    {
        return (new PathaoAuth)->getNewAccesstoken();
    }
}
