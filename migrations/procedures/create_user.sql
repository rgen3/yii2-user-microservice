create or replace function create_user(
  in i_username character varying(255),
  in i_password text,
  in i_email character varying (100),
  in i_mother_language char(3) default 'RUS',
  in i_first_name character varying(255) default null,
  in i_last_name character varying(255) default null,
  in i_patronymic character varying(255) default null,
  in i_status integer default 0,
  in i_role integer default 1,
  out o_id int,
  out o_username character varying(32),
  out o_confirmation_code character varying(32),
  out o_error int
)
  returns record as $$
declare
  v_password_salt text := gen_salt('bf');
  v_password_hash text := crypt(i_password, v_password_salt);

  ERROR_EMAIL_OR_USERNAME_ALREADY_TAKEN int := 1000;
begin
  o_error := 0;

  insert into public.user
  (
    username,
    mother_language,
    first_name,
    last_name,
    patronymic,
    password_hash,
    password_salt,
    email,
    confirmation_code,
    confirmation_send_at,
    status,
    role,
    created_at,
    confirmed_at,
    updated_at
  )
  values
    (
      i_username,
      i_mother_language,
      i_first_name,
      i_last_name,
      i_patronymic,
      v_password_hash,
      v_password_salt,
      i_email,
      md5(gen_salt('md5')),
      current_timestamp,
      i_status,
      i_role,
      current_timestamp,
      null,
      null
    )
  returning id, username, confirmation_code
  into o_id, o_username, o_confirmation_code;

  exception
  when unique_violation then
    o_error := ERROR_EMAIL_OR_USERNAME_ALREADY_TAKEN;
end;
$$ language plpgsql;
