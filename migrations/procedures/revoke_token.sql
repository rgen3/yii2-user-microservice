create or replace function public.revoke_token(
      i_token_id UUID,
      i_user_id bigint default null,
      out o_active_until timestamp
)
  returns timestamp as $$
begin
  update public.user_jwt
  set is_revoked = true
  where token_id = i_token_id
    and (i_user_id is null or user_id = i_user_id)
  returning active_until into o_active_until;
end;
$$ language plpgsql;
