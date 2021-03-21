import gql from 'graphql-tag';

export const typeDefs = gql`
  type userToken {
    access_token: String!
    token_type: String!
    expires_in: Int!
  }

  type Mutation {
    auth(
      email: String!
      password: String!
    ): userToken
  }
`;
