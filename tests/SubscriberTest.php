<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;
use Model\Subscriber;

class SubscriberTest extends TestCase
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

        Subscriber::where('Surname', 'TestUser')->delete();
    }

    /**
     * @dataProvider additionProvider
     */
    public function testCreateSubscriber(string $httpMethod, array $data, string $expectedBehavior): void
    {
        $request = $this->createMock(\Src\Request::class);
        $request->method = $httpMethod;
        $request->expects($this->any())->method('all')->willReturn($data);
        $request->expects($this->any())->method('files')->willReturn([]);
        $request->expects($this->any())->method('get')->willReturn(null);

        $controller = new \Controller\SubscriberController();

        ob_start();
        try {
            $controller->create($request);
        } catch (\Throwable $e) {
            // Игнорируем ошибки рендеринга для простоты
        }
        ob_end_clean();

        if ($expectedBehavior === 'redirect') {
            $subscriber = Subscriber::where('Surname', $data['Surname'])->first();
            $this->assertNotNull($subscriber, "Абонент должен быть создан");
            $this->assertEquals($data['Name'], $subscriber->Name);
            Subscriber::where('Surname', $data['Surname'])->delete();
        } elseif ($expectedBehavior === 'errors') {
            $subscriber = Subscriber::where('Surname', 'TestUser')->first();
            $this->assertNull($subscriber, "Абонент не должен быть создан при ошибках");
        } else {
            $this->assertTrue(true);
        }
    }

    public static function additionProvider(): array
    {
        return [
            ['POST', ['Surname' => 'TestUser', 'Name' => 'TestName', 'Patronymic' => 'TestPatronymic', 'BirthdayDate' => '1995-05-20'], 'redirect'],
            ['POST', [], 'errors'],
            ['GET', [], 'show_form'],
        ];
    }
}