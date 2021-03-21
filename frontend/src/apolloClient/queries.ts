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
      accessToken
      tokenType
      expiresIn
    }
  }
`;
