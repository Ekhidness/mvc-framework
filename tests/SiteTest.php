<?php
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;

class SiteTest extends TestCase
{
    protected function setUp(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $projectRoot = dirname(__DIR__);
        $_SERVER['DOCUMENT_ROOT'] = $projectRoot;
        $_SERVER['SCRIPT_NAME'] = '/index.php';

        $appConfig = include $projectRoot . '/config/app.php';
        $dbConfig = include $projectRoot . '/config/db.php';
        $pathConfig = include $projectRoot . '/config/path.php';

        $GLOBALS['app'] = new \Src\Application([
            'providers' => $appConfig['providers'],
            'settings' => [
                'app' => $appConfig,
                'db' => $dbConfig,
                'path' => $pathConfig,
            ]
        ]);

        try {
            $capsule = new Capsule;
            $capsule->addConnection($dbConfig);
            $capsule->setAsGlobal();
            $capsule->bootEloquent();
        } catch (\Exception $e) {}

        if (!function_exists('app')) {
            function app() { return $GLOBALS['app']; }
        }
    }

    /**
     * @dataProvider additionProvider
     * @runInSeparateProcess
     */
    public function testSignup(string $httpMethod, array $userData, string $expectedResult): void
    {
        if ($userData['login'] === 'login is busy') {
            $existing = \Model\User::first();
            $userData['login'] = $existing ? $existing->login : 'admin';
        }

        $request = $this->getMockBuilder(\Src\Request::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['all'])
            ->getMock();

        $request->method = $httpMethod;
        $request->expects($this->any())->method('all')->willReturn($userData);

        ob_start();
        $exceptionThrown = false;
        $exceptionMessage = '';
        try {
            $result = (new \Controller\Site())->signup($request);
        } catch (\Throwable $e) {
            $exceptionThrown = true;
            $exceptionMessage = $e->getMessage();
        }
        $output = ob_get_clean();
        $fullResponse = $result . $output;

        if ($expectedResult === 'redirect') {
            if ($exceptionThrown) {
                $this->fail("Ошибка при регистрации: $exceptionMessage");
            }
            $userExists = \Model\User::where('login', $userData['login'])->exists();
            $this->assertTrue($userExists, 'Пользователь не создан в БД');
            \Model\User::where('login', $userData['login'])->delete();

            if (function_exists('xdebug_get_headers')) {
                $headers = xdebug_get_headers();
                $hasRedirect = false;
                foreach ($headers as $header) {
                    if (str_contains($header, 'Location:')) {
                        $hasRedirect = true;
                        break;
                    }
                }
                $this->assertTrue($hasRedirect, 'Редирект не найден в заголовках');
            }
        } else {
            if ($exceptionThrown) {
                $this->fail("Ошибка рендеринга: $exceptionMessage");
            }
            $this->assertStringContainsString($expectedResult, $fullResponse);
        }
    }

    public static function additionProvider(): array
    {
        return [
            ['GET', ['name' => '', 'login' => '', 'password' => ''], 'Регистрация'],
            ['POST', ['name' => '', 'login' => '', 'password' => ''], 'Поле Login обязательно'],
            ['POST', ['name' => 'test', 'login' => 'login is busy', 'password' => '123456'], 'уникально'],
            ['POST', ['name' => 'TestUser', 'login' => 'test_' . time(), 'password' => 'securepass'], 'redirect'],
        ];
    }
}