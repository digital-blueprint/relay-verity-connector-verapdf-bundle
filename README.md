# DbpRelayVerityConnectorVerapdfBundle

[GitHub](https://github.com/{{bundle-path}}) |
[Packagist](https://packagist.org/packages/dbp/relay-verity-connector-verapdf-bundle)

The Verity Connector VeraPDF bundle provides an API for interacting with VeraPDF wich is a PDF validating service.

## Bundle installation

You can install the bundle directly from [packagist.org](https://packagist.org/packages/dbp/relay-verity-connector-verapdf-bundle).

```bash
composer require dbp/relay-verity-connector-verapdf-bundle
```

## Integration into the Relay API Server

* Add the bundle to your `config/bundles.php` in front of `DbpRelayCoreBundle`:

```php
...
Dbp\Relay\VerityConnectorVerapdfBundle\DbpRelayVerityConnectorVerapdfBundle::class => ['all' => true],
Dbp\Relay\CoreBundle\DbpRelayCoreBundle::class => ['all' => true],
];
```

If you were using the [DBP API Server Template](https://packagist.org/packages/dbp/relay-server-template)
as template for your Symfony application, then this should have already been generated for you.

* Run `composer install` to clear caches

## Configuration

The bundle has a `url` configuration value that you can specify in your app, either by hard-coding it,
or by referencing an environment variable.

There is also a `maxsize` configuration value, specifying the maximum size of a document sent to the VeraPDF backend.

For this create `config/packages/dbp_relay_verity-connector-verapdf.yaml` in the app with the following
content:

```yaml
dbp_relay_verity_connector_verapdf:
  url: '%env(VERA_PDF_URI)%'
  maxsize: 33554432
```

If you were using the [DBP API Server Template](https://packagist.org/packages/dbp/relay-server-template)
as template for your Symfony application, then the configuration file should have already been generated for you.

For more info on bundle configuration see <https://symfony.com/doc/current/bundles/configuration.html>.

## Development & Testing

* Install dependencies: `composer install`
* Run tests: `composer test`
* Run linters: `composer run lint`
* Run cs-fixer: `composer run cs-fix`

## Bundle dependencies

Don't forget you need to pull down your dependencies in your main application if you are installing packages in a bundle.

```bash
# updates and installs dependencies of dbp/relay-verity-connector-verapdf-bundle
composer update dbp/relay-verity-connector-verapdf-bundle
```
