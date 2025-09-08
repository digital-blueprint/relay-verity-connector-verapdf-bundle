# Configuration

There are some values that you can define in your bundle config.

 - `url`: url that leads to the verapdf rest API
 - `maxsize`: maximum size in bytes that documents are allow to have

```yaml
dbp_relay_verity_connector_verapdf:
  url: '%env(VERAPDF_URL)%'
  maxsize: '10485760'
```