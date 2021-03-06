<?php
declare(strict_types = 1);

use yii\db\Migration;

class m150101_000000_init extends Migration
{
    public function up()
    {
        $this->execute('create extension if not exists pgcrypto');
        $this->execute("
            CREATE TABLE IF not EXISTS public.user (
                  id bigserial primary key,
                  username varchar(255) not null,
                  mother_language char(3) default 'RUS',
                  first_name varchar(255),
                  last_name varchar (255),
                  patronymic varchar(255),
                  password_hash varchar(255) not null,
                  password_salt varchar(255) not null,
                  email varchar(100) not null,
                  confirmation_code varchar(32),
                  confirmation_send_at timestamp,
                  status smallint not null,
                  role int not null,
                  created_at timestamp default current_timestamp,
                  confirmed_at timestamp default null,
                  updated_at timestamp default current_timestamp
              )
        ");

        $this->execute("create unique index on public.user (username)");
        $this->execute("create unique index on public.user (email)");

        $this->execute("
            create table if not exists public.user_contact_confirmation (
              user_id bigint,
              contact_id bigint default null,
              confirmation_code character varying(32),
              created_at timestamp default current_timestamp
            );
        ");

        $this->execute("
            create table if not exists public.user_contact (
              id bigserial primary key,
              user_id bigint,
              contact_type smallint,
              contact character varying (100),
              is_confirmed boolean,
              created_at timestamp default current_timestamp
            )
        ");

        $this->execute("
            create table if not exists public.user_jwt (
              token_id UUID primary key,
              user_id bigint,
              refresh_token UUID default gen_random_uuid() not null,
              jwt text,
              is_revoked boolean default false,
              active_from timestamp default current_timestamp,
              active_until timestamp default current_timestamp + '14 days'::interval
            )
        ");

        $this->execute('create index user_jwt__refresh_token on public.user_jwt (refresh_token);');

        $this->execute(file_get_contents(ROOT_DIR . '/migrations/procedures/check_credentials.sql'));
    }

    public function down()
    {
        return parent::down(); // TODO: Change the autogenerated stub
    }
}