create or replace table products
(
    id         bigint auto_increment primary key,
    name       varchar(255)  not null,
    sku        varchar(255)  not null,
    price      decimal(8, 2) not null,
    constraint products_sku_unique_key
        unique (sku)
);

create or replace table product_attributes_values
(
    id         bigint auto_increment primary key,
    attribute  varchar(255) not null,
    product_id bigint       not null,
    value      varchar(255) not null,
    unit       varchar(100) null,
    constraint product_attributes_values_product_id_attribute_unique_key
        unique (product_id, attribute),
    constraint product_attributes_values_product_id___fk
        foreign key (product_id) references products (id)
            on update cascade on delete cascade
);

