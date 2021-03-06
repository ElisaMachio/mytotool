import useAuthentication from "../hooks/useAuthentication";
import React from "react";
import AuthContext from "../contexts/AuthContext";

// Mis en place du context via le provider
const AuthProvider = ({ children }) => {
  const { token, user, signIn, signUp, logout } = useAuthentication();

  return (
    <AuthContext.Provider
      value={{
        token,
        user: user,
        signIn: signIn,
        signUp: signUp,
        logout: logout,
      }}
    >
      {children}
    </AuthContext.Provider>
  );
};

export default AuthProvider;
