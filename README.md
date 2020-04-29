<a name="table-of-contents"></a>
## Table of contents

- [Get Started](#get-started)
- [AUTH API](#auth-api)
- Testing
	- [Mock Server](#mock-server)
	- [CURL Testing Commands](#curl-testing-commands)
	- [Other Language Versions](#other-language-versions)

<a name="get-started"></a>
# Get Started

- Get API code and API secret on web admin console
- Refer to [mock server](#mock-server) sample code 

<a name="auth-api"></a>
# AUTH API
Refer to [here](https://github.com/CYBAVO/AUTH_MOCK_SERVER#register-new-user) for detailed API documentation.


<a name="mock-server"></a>
# Mock Server

## Setup Configuration
>	Set following configuration in mockserver.conf.php
>> Require API code and API secret on web admin console

```
$api_server_url = 'BACKEND_SERVER_URL';
$api_code = 'SERVICE_API_CODE';
$api_secret = 'SERVICE_API_SECRET';
```

## Register mock server callback URL
>	Operate on web admin console

Callback URL

```
http://localhost:8892/v1/mock/callback
```

## How to run
> Required version: PHP 7.3.7 or later

- If you have PHP installed then use following command to start the built-in web server.
	- > cd AUTH\_MOCK\_SERVER\_PHP\_PATH
	- > php -S 0.0.0.0:8892
- Otherwise use docker to setup mock server.
	- > docker run --name mockserver -d -v AUTH\_MOCK\_SERVER\_PHP\_PATH:/var/www/html -p 8892:8892 php:7.3.7-fpm
	- > docker exec -it mockserver bash
	- > php -S 0.0.0.0:8892

<a name="curl-testing-commands"></a>
## CURL Testing Commands

Refer to [here](https://github.com/CYBAVO/AUTH_MOCK_SERVER#curl-testing-commands) for curl testing commands.

<a name="other-language-versions"></a>
## Other Language Versions
- [GO](https://github.com/CYBAVO/AUTH_MOCK_SERVER)
- [Javascript](https://github.com/CYBAVO/AUTH_MOCK_SERVER_JAVASCRIPT)
