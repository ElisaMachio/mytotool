import { createContext } from "react";

const defaultContext = {
  token: undefined,
  user: undefined,
  signIn: undefined,
  signUp: undefined,
  logout: undefined,
};

const AuthContext = createContext(defaultContext);

export default AuthContext;
