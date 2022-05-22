import * as React from "react";
import "./App.css";
import MyToTool from "./pages/MyToTool";
import SignUp from "./pages/Signup";
import SignIn from "./pages/Signin";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import NotFoundPage from "./pages/NotFoundPage";
import AuthContext from "./contexts/AuthContext";

function Router() {
  const { token } = React.useContext(AuthContext);

  if (token) {
    return (
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<MyToTool />} />
          <Route path="*" element={<NotFoundPage />} />
        </Routes>
      </BrowserRouter>
    );
  } else {
    return (
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<SignIn />} />
          <Route path="/signin" element={<SignIn />} />
          <Route path="/signup" element={<SignUp />} />
          <Route path="*" element={<NotFoundPage />} />
        </Routes>
      </BrowserRouter>
    );
  }
}

export default Router;
