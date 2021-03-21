import gql from 'graphql-tag';

export const authUserMutation = gql`
  mutation(
    $email: String!
    $password: String!
  ) {
    auth(
      email: $email
      password: $password
    ) {
      access_token
      token_type
      expires_in
    }
  }
`;
