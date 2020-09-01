DROP TABLE IF EXISTS "users" CASCADE;
DROP TABLE IF EXISTS "user_sessions" CASCADE;
DROP TABLE IF EXISTS "shipping" CASCADE;
DROP TABLE IF EXISTS "couriers" CASCADE;
DROP TABLE IF EXISTS "payment_methods" CASCADE;
DROP TABLE IF EXISTS "payment" CASCADE;
DROP TABLE IF EXISTS "items" CASCADE;
DROP TABLE IF EXISTS "orders" CASCADE;
DROP TYPE IF EXISTS "status" CASCADE;


CREATE TABLE users(
    user_id SERIAL Primary Key,
	user_email VARCHAR(30) UNIQUE,
    user_taxnum BIGINT UNIQUE,
	user_password TEXT,
	confirmed bool 
);

CREATE TABLE couriers(
	courier_id SERIAL PRIMARY KEY,
	courier_name VARCHAR(20)
);

CREATE TABLE payment_methods(
	payment_method_id SERIAL PRIMARY KEY ,
	payment_method_name VARCHAR(20)
	
);

CREATE TABLE items(
	item_id SERIAL PRIMARY KEY,
	user_id int REFERENCES users(user_id),
	item_name TEXT NOT NULL,
	item_description TEXT NOT NULL,
	item_grossprice int NOT NULL,
	item_image TEXT NOT NULL,
	item_saleprice int,
	item_seoname TEXT,
	item_seodescription TEXT,
	item_ogimage TEXT,
	item_courier int REFERENCES  couriers(courier_id)
	
);
CREATE TABLE shipping(
	item_id int REFERENCES items(item_id),
	courier_id int REFERENCES couriers(courier_id),
	shipping_price int
);
CREATE TABLE payment(
	item_id int REFERENCES items(item_id),
	payment_method_id int REFERENCES payment_methods(payment_method_id),
	payment_handlingfee int
);
CREATE TYPE status AS ENUM ('beerkezett','feldolgozas alatt','kiszallitas alatt','kiszallitva','torolve');

CREATE TABLE orders(
	order_id SERIAL PRIMARY KEY,
	customer_name TEXT,
	customer_shipping_address TEXT,
	customer_billing_address TEXT,
	customer_phone VARCHAR(12),
	customer_email TEXT,
	item_id int REFERENCES items(item_id),
	item_quantity int,
	order_status status 
	
);
