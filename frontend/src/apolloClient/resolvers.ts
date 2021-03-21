import gql from 'graphql-tag';

export const typeDefs = gql`
  type userToken {
    accessToken: String!
    tokenType: String!
    expiresIn: Int!
  }

  type Mutation {
    auth(
      email: String!
      password: String!
    ): userToken
  }
`;
