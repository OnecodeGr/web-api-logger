# Monitor the magento 2 API REQUEST you are getting 

[![GitHub version](https://badge.fury.io/gh/OnecodeGr%2Fweb-api-logger.svg)](https://badge.fury.io/gh/OnecodeGr%2Fweb-api-logger)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](./LICENSE.md)
[![PHP Version Require](http://poser.pugx.org/onecode/web-api-logger/require/php)](https://packagist.org/packages/onecode/web-api-logger)
[![Supported Magento Version](https://img.shields.io/badge/magento-2.3.x_2.4.x-brightgreen.svg?logo=magento&longCache=true)](https://packagist.org/packages/onecode/shopflix-connector)

This extension is tracking the API request you are getting in your magento installation by user
## 1. How to install Onecode_WebApiLogger
There are 2 ways to install the application via composer(recommended) or Copy and paste
### 1.1 Install via composer

```
composer require onecode/web-api-logger
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
php bin/magento setup:di:compile
```
### 1.2 Copy and paste

If you don't want to install via composer, you can use this way.

- Download [the latest version here](https://github.com/OnecodeGr/web-api-logger/archive/master.zip)
- Extract `master.zip` file to `app/code/Onecode/WebApiLogger` ; You should create a folder
  path `app/code/Onecode/WebApiLogger` if not exist.
- Require Onecode_Base before installation run the command ``composer require onecode/base`` or Download [the latest](https://github.com/OnecodeGr/base/archive/master.zip). Extract `master.zip` file to `app/code/Onecode/Base`  ; You should create a folder
  path `app/code/Onecode/Base` if not exist.
- Go to Magento root folder and run upgrade command line to install `Onecode_WebApiLogger`:
```
php bin/magento module:enable Onecode_WebApiLogger Onecoode_Base
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

Run compile if you have your application in Production Mode

```
php bin/magento setup:di:compile
```

## 2. Magento 2 WebApiLogger extension

### 2.1 Web API Logger 
In this guide we will show you how to configure the extension and use it.

![Imgur](https://i.imgur.com/3yO5PXb.png)

### 2.2  Web API Logger settings

Login to the **Magento Admin**, navigate to `Store > Configuration > Onecode Extensions > Web API Logger`

#### 2.2.1 General

![Imgur](https://i.imgur.com/CHDiCzX.png)

**Enabled**: Select `Yes` to activate the module and No to disable it.

![Imgur](https://i.imgur.com/6cuMh3h.png)

**Clean Up**: Set the days you want to clear the log by database. Set 0 to disable it.

![Imgur](https://i.imgur.com/sQWqmut.png)

**Accept all HTTP Method**: Select `Yes` to save on logger all the request you are getting or `No` to select which request you want to monitor

![Imgur](https://i.imgur.com/dvECorT.png)

**Select HTTP Methods**: Select which API methods do you want to monitor.

![Imgur](https://i.imgur.com/KsuUXTe.png)

**Select user you want to track**: Select which users request do you want to monitor

![Imgur](https://i.imgur.com/uEtgtsI.png)






