<?php
	include("config.php");

	$token = getAccessToken($clientId, $clientSecret);
	$latestRelease = getLatestRelease($artistId, $token);
	$redirectUrl = $latestRelease['external_urls']['spotify'];

	header("Location: $redirectUrl");
	exit();

	function getAccessToken($clientId, $clientSecret) {
		$authEndpoint = 'https://accounts.spotify.com/api/token';
		$authHeader = base64_encode($clientId . ':' . $clientSecret);
	
		$authData = http_build_query([
			'grant_type' => 'client_credentials',
		]);
	
		$authOptions = [
			'http' => [
				'header'  => [
					"Authorization: Basic $authHeader",
					"Content-Type: application/x-www-form-urlencoded"
				],
				'method'  => 'POST',
				'content' => $authData,
			],
		];
	
		$authContext = stream_context_create($authOptions);
		$authResult = file_get_contents($authEndpoint, false, $authContext);
	
		if ($authResult === FALSE) {
			die('Error retrieving the access token.');
		}
	
		$authResult = json_decode($authResult, true);
	
		if (!isset($authResult['access_token'])) {
			die('No access token returned.');
		}
	
		return $authResult['access_token'];
	}

	function getLatestRelease($artistId, $token) {
		$latestReleaseEndpoint = "https://api.spotify.com/v1/artists/$artistId/albums?limit=1&market=DE&include_groups=single";

		$latestReleaseOptions = [
			'http' => [
				'header'  => "Authorization: Bearer $token",
				'method'  => 'GET',
			],
		];

		$latestReleaseContext = stream_context_create($latestReleaseOptions);
		$latestReleaseResult = file_get_contents($latestReleaseEndpoint, false, $latestReleaseContext);
		$latestReleaseResult = json_decode($latestReleaseResult, true);

		return $latestReleaseResult['items'][0];
	}
?>