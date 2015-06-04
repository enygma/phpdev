## Setup

1. Check out the latest version of the code: `git clone https://github.com/enygma/phpdev.git`
2. Run the `composer.phar install`
3. Copy the `phinx.yml` file from `vendor/psecio/gatekeeper` to the current directory
4. Copy it to `phinx-phpdev.yml` and edit the "migrations" line to just say:

```
migrations: migrations
```

5. Run the phpdev migrations first: `vendor/bin/phinx migrate -c phpdev-migrations.yml`
6. Run the Gatekeeper migrations second: `vendor/bin/phinx migrate`

Then ensure the database and table encodings are correct:

```
SELECT default_character_set_name FROM information_schema.SCHEMATA S
	WHERE schema_name = "phpdev";
```

and

```
SELECT CCSA.character_set_name FROM information_schema.`TABLES` T,
    information_schema.`COLLATION_CHARACTER_SET_APPLICABILITY` CCSA
	WHERE CCSA.collation_name = T.table_collation
	AND T.table_schema = "phpdev"
    AND T.table_name = "news";
```

Ideally they're all `utf8`