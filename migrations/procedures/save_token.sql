create or replace function save_token(
  i_token_id uuid,
  i_user_id int,
  i_token text,
  out o_refresh_token uuid,
  out o_error int
)
  returns record as $$
declare
  ERROR_SAVING_JWT_TOKEN constant int := 2000;

begin
  o_error := 0;

  insert into public.user_jwt
    (user_id, jwt, token_id)
  values
    (i_user_id, i_token, i_token_id)
  returning refresh_token into o_refresh_token;

  exception
  when unique_violation then
    o_error := ERROR_SAVING_JWT_TOKEN;
end;
$$ language plpgsql;