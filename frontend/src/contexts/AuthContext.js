import { createContext } from "react";

// Context pour acceder au donnes depuis n'importe ou
const defaultContext = {
  token: undefined,
  user: undefined,
  signIn: undefined,
  signUp: undefined,
  logout: undefined,
};

const AuthContext = createContext(defaultContext);

export default AuthContext;
