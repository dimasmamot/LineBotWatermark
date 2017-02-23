<?php

require __DIR__ . '/vendor/autoload.php';

use \LINE\LINEBot\SignatureValidator as SignatureValidator;

// load config
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

// initiate app
$configs =  [
	'settings' => ['displayErrorDetails' => true],
];
$app = new Slim\App($configs);

/* ROUTES */
$app->get('/', function ($request, $response) {
	return "Lanjutkan!";
});

$app->post('/', function ($request, $response)
{
	// get request body and line signature header
	$body 	   = file_get_contents('php://input');
	$signature = $_SERVER['HTTP_X_LINE_SIGNATURE'];

	// log body and signature
	file_put_contents('php://stderr', 'Body: '.$body);

	// is LINE_SIGNATURE exists in request header?
	if (empty($signature)){
		return $response->withStatus(400, 'Signature not set');
	}

	// is this request comes from LINE?
	if($_ENV['PASS_SIGNATURE'] == false && ! SignatureValidator::validateSignature($body, $_ENV['CHANNEL_SECRET'], $signature)){
		return $response->withStatus(400, 'Invalid signature');
	}

	// init bot
	$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['CHANNEL_ACCESS_TOKEN']);
	$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['CHANNEL_SECRET']]);

	$data = json_decode($body, true);
	foreach ($data['events'] as $event)
	{
		if ($event['type'] == 'message')
		{
			if($event['message']['type'] == 'text'){

				$imageMessageBuilder = new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder('https://www.dicoding.com/images/original/event/201606040711539199595206d49d7359e6787605e3f74b.png','https://www.dicoding.com/images/original/event/201606040711539199595206d49d7359e6787605e3f74b.png');

				if($event['message']['text'] == 'adit')
					$result = $bot->replyText($event['replyToken'], "Nomor HP Adit - 085746628171");
				elseif ($event['message']['text'] == 'lyo')
					$result = $bot->replyText($event['replyToken'], "Nomor HP Lyo - 082245147870");
				elseif ($event['message']['text'] == 'iskandar')
					$result = $bot->replyText($event['replyToken'], "Nomor HP Iskandar - 087851084549");
				elseif ($event['message']['text'] == 'mamot')
					$result = $bot->replyText($event['replyToken'], "Nomor HP Mamot Ganteng - 081235691435");
				elseif ($event['message']['text'] == 'intan')
					$result = $bot->replyText($event['replyToken'], "Nomor HP Intun - 081231793906");
				elseif ($event['message']['text'] == 'tia')
					$result = $bot->replyText($event['replyToken'], "Nomor HP Tiyul - 081230436732");
				elseif ($event['message']['text'] == 'adam')
					$result = $bot->replyText($event['replyToken'], "Nomor HP Adam - 085748454716");
				elseif ($event['message']['text'] == 'ajiz')
					$result = $bot->replyText($event['replyToken'], "Nomor HP Ajis - 083856535951");
				elseif ($event['message']['text'] == 'yafie')
					$result = $bot->replyText($event['replyToken'], "Nomor HP Yafie - 0812552578019");
				elseif ($event['message']['text'] == 'ilzam')
					$result = $bot->replyText($event['replyToken'], "Nomor HP Ilzam - 085607569909");
				elseif ($event['message']['text'] == 'sisil')
					$result = $bot->replyText($event['replyToken'], "Nomor HP Sisil - 081934713933");
				elseif ($event['message']['text'] == 'yunaz')
					$result = $bot->replyText($event['replyToken'], "Nomor HP Yunas Brewok - 082257170526");
				elseif ($event['message']['text'] == 'tasya')
					$result = $bot->replyText($event['replyToken'], "Nomor HP Tante Tasya - 081615655842");
				elseif ($event['message']['text'] == 'fatih')
					$result = $bot->replyText($event['replyToken'], "Nomor HP Fatih - 082230410667");
				elseif ($event['message']['text'] == 'kates')
					$result = $bot->replyText($event['replyToken'], "Nomor HP Kates - 085655164677");
				elseif ($event['message']['text'] == 'putra')
					$result = $bot->replyText($event['replyToken'], "Nomor HP Putra - 081334175435");
				elseif ($event['message']['text'] == 'hasna')
					$result = $bot->replyText($event['replyToken'], "Nomor HP Hasnatun - 081296152581");
				elseif ($event['message']['text'] == 'test')
					$result = $bot->replyMessage($event['replyToken'], $imageMessageBuilder);
				else
					return 0;				

				// or we can use pushMessage() instead to send reply message
				// $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($event['message']['text']);
				// $result = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
				
				return $result->getHTTPStatus() . ' ' . $result->getRawBody();
			}

			// if($event['message']['type'] == 'image'){
			// 	$result = $bot->replyMessage($event['replyToken'], $textMessageBuilder

			// 	return $result->getHTTPStatus() . ' ' . $result->getRawBody();
			// }
		}
	}

});

	// $app->get('/push/{to}/{message}', function ($request, $response, $args)
	// {
	// $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['CHANNEL_ACCESS_TOKEN']);
	// $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['CHANNEL_SECRET']]);

	// $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($args['message']);
	// $result = $bot->pushMessage($args['to'], $textMessageBuilder);

	// return $result->getHTTPStatus() . ' ' . $result->getRawBody();
	// });

/* JUST RUN IT */
$app->run();