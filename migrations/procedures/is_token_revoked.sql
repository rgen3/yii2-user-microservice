create or replace function public.is_token_revoked(
    i_token_id UUID,
  out o_is_revoked boolean,
  out o_error int
)
  returns record as $$
declare
  ERROR_TOKEN_NOT_FOUND constant int := 2001;
begin
  o_error := 0;

  select is_revoked into o_is_revoked from user_jwt where i_token_id = token_id;

  if not FOUND then
    o_error := ERROR_TOKEN_NOT_FOUND;
  end if;
end;
$$ language plpgsql;
