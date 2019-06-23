# Sms Sender

A CLI application to send SMS from a database queue. 

It uses [Infobip](https://infobip.com) api to send messages, thus requires you to supply a valid Infobip Username and Password.

Out of the box it works with Oracle database, but also supports:

* PostgresSQL
* MySQL
* Sql Server
* Sqlite

It can work with any database supported by a Laravel database driver.

## Usage

<b>Step 1</b>: Clone this repository to your PC.

```bash
git clone https://github.com/tumainimosha/sms-sender.git
```

<b>Step 2</b>: Configure Environment variables

Rename the `.env.example` file to `.env`

Edit `.env` file and substitute your credentials

Set infobip api credentials
```dotenv
# Infobip Credentials
INFOBIP_USERNAME=infobip-user
INFOBIP_PASSWORD=infobip-pass
INFOBIP_FROM="SENDER NAME"
```

Set database credentials

```dotenv
# Database Credentials
DB_CONNECTION=oracle # Valid values: oracle, pgsql, mysql, sqlsrv, sqlite 
DB_HOST=10.10.0.5
DB_PORT=1521
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

<b>Step 3</b>: Install composer dependencies

* This step requires you to have at-least `PHP7.1`, `composer` installed.
* Ensure your PHP installation has necessary database driver for database you are working with.

Step 4: Setup database table

* <i>Option 1</i>: use the default table schema for messages

| outgoing_sms             |
|--------------------------|
| id PRIMARY_KEY           |
| msisdn VARCHAR(255)      |
| text TEXT                |
| sender_name VARCHAR(255) |
| sent_at TIMESTAMP        |

You can create this table yourself directly on your db or use the scripts migration to create it

```bash
php sms-sender migrate
```

The migrate script will create this table for you

* <i>Option 2</i>: use your own custom table schema for messages

If you choose to use different table name and columns from the ones specified above, edit the `.env` file to specify the customizations you are using

```dotenv
# SMS table config
TABLE_OUTGOING_SMS=outgoing_sms
COLUMN_PRIMARY_KEY=id
COLUMN_MSISDN=msisdn
COLUMN_TEXT=text
COLUMN_SENDER_NAME=sender_name
COLUMN_SENT_AT=sent_at
```

<b>Step 5</b>: Test running the script

```bash
$ php sms-sender process         
Fetch pending messages from DB: ✔
Sending messages: ✔
```

<b>Step 6</b>: Schedule the script to run at given intervals 

You can schedule it using your OS's task schedule to run at given intervals, say once per minute.

It will fetch all pending messages at that time, send them, and update `sent_at` column to time of sending the sms.

## Testing
Run the tests with:

``` bash
vendor/bin/phpunit
```

## Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security
If you discover any security-related issues, please email instead of using the issue tracker.

## License
The MIT License (MIT). Please see [License File](/LICENSE.md) for more information.
