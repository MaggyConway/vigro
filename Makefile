#####################################
#        	MakeFile 
#####################################
install:
	cp .env.example .env
	docker-compose up -d
	docker exec bitrix composer install
	mkdir -p .docker/dump
	cp ../maxonor/upload/dump/db_dump.sql .docker/dump/db_dump.sql
	make db-import
	docker exec bitrix php local/bin/migrate.php up

#####################################
#        	PHP Exchange 
#####################################
php-exchange-product:
	php local/modules/sntinvest.integration/run exchange:product

#####################################
#        	Вump 
#####################################

db-download:
	wget stage.vigro.ru/upload/dumps/db_dump.sql -O ./.docker/dump/db_dump.sql

# Импорт базы
db-import:
	docker exec -i db mysql -uroot -p123 bitrix < ./.docker/dump/db_dump.sql

db-dump:
	mysqldump -ubitrix0 -pZ4J0\!4KE{AV+R{uiLNZv sitemanager > ./upload/dumps/db_dump.sql

#####################################
#        MARKET OZON IMPORT
#####################################

# Выгрузка общая из озон
market-ozon-import:
	make market-ozon-products
	make market-ozon-sku
	make market-ozon-status

# Выгрузка товаров из озон
market-ozon-products:
	docker exec bitrix php local/modules/sntinvest.market/run market:ozon products

# Выгрузка статусов из озон
market-ozon-status:
	docker exec bitrix php local/modules/sntinvest.market/run market:ozon status

# Выгрузка SKU из озон
market-ozon-sku:
	docker exec bitrix php local/modules/sntinvest.market/run market:ozon sku

#####################################
#        MARKET YANDEX IMPORT
#####################################

# Выгрузка общая из yandex
market-yandex-import:
	make market-yandex-products
	make market-yandex-sku
	make market-yandex-status

# Выгрузка товаров из yandex
market-yandex-products:
	docker exec bitrix php local/modules/sntinvest.market/run market:yandex products

# Выгрузка статусов из yandex
market-yandex-status:
	docker exec bitrix php local/modules/sntinvest.market/run market:yandex status

# Выгрузка SKU из yandex
market-yandex-sku:
	docker exec bitrix php local/modules/sntinvest.market/run market:yandex sku


