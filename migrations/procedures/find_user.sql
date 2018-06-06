create or replace function find_user(
  in i_user_id bigint default null,
  in i_email character varying(100) default null,
  in i_username character varying(255) default null,
  out o_username varchar(255),
  out o_mother_language char(3),
  out o_first_name varchar(255),
  out o_last_name varchar(255),
  out o_patronymic varchar(255),
  out o_email varchar(100),
  out o_status smallint,
  out o_role integer,
  out o_created_at timestamp,
  out o_confirmed_at timestamp,
  out o_updated_at timestamp
)
  returns setof record as $$
begin
  if coalesce(i_user_id::text, i_email::text, i_username::text) is null then
    return;
  end if;

  return query
    select
      username,
      mother_language,
      first_name,
      last_name,
      patronymic,
      email,
      status,
      role,
      created_at,
      confirmed_at,
      updated_at
    from public.user
    where
      (i_user_id is null or id = i_user_id)
      and (i_email is null or email = i_email)
      and (i_username is null or username = i_username)
    limit 1;
end;
$$ language plpgsql;
