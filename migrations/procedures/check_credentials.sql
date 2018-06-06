create or replace function check_credentials(
  i_username character varying (255) default null,
  i_email character varying (100) default null,
  i_password text default '',
  out o_user_id int,
  out o_error int
)
  returns record as $$
declare
  ERROR_INVALID_LOGIN_CREDENTIALS constant int := 1010;

  v_password_salt character varying (255);
  v_password_hash character varying (255);
begin
  o_error := 0;

  if i_password = '' then
    o_error := ERROR_INVALID_LOGIN_CREDENTIALS;
    return;
  end if;

  select id, password_salt, password_hash
  into o_user_id, v_password_salt, v_password_hash
  from public.user
  where (i_username is not null and i_username = username)
  or (i_email is not null and i_email = email);

  if not FOUND then
    o_error := ERROR_INVALID_LOGIN_CREDENTIALS;
    return;
  end if;

  if crypt(i_password, v_password_salt) <> v_password_hash then
    o_error := ERROR_INVALID_LOGIN_CREDENTIALS;
    return;
  end if;

end;
$$ language plpgsql;