create or replace function confirm_email(
  in i_email character varying(100),
  in i_confirmation_code character varying(32)
)
  returns boolean as $$
declare
  v_updated numeric;
begin
  update public.user
  set confirmed_at = current_timestamp,
      confirmation_code = null,
      updated_at = current_timestamp,
      status = 1
  where email = i_email
    and confirmation_code = i_confirmation_code
    and status > 0
    and confirmation_code is not null;

  GET DIAGNOSTICS v_updated = ROW_COUNT;

  if v_updated > 0 then
    return true;
  end if;

  return false;
end;
$$ language plpgsql;