# Magento 2 Cron Debug Module

A Magento 2 module that provides a CLI command to manually execute cron jobs for debugging purposes.

## Installation

1. Add the repository to your `composer.json`:

```bash
composer config repositories.rnab-module-cron vcs https://github.com/Roy-Nilsson-AB/Magento-Module-Cron
```

2. Install the module:

```bash
composer require rnab/module-cron
bin/magento module:enable Rnab_Cron
bin/magento setup:upgrade
```

## Usage

Run a specific cron job by its job code:

```bash
bin/magento cron:run <job_code>
```

### Example

```bash
bin/magento cron:run catalog_index_refresh_price
```

## Purpose

This module is designed to help developers debug Magento cron jobs by allowing them to:
- Execute specific cron jobs on demand without waiting for the cron schedule
- Test cron job execution in isolation
- Debug cron job issues more efficiently

## Requirements

- PHP 7.4 or 8.0+
- Magento 2.4.x

## License

MIT
