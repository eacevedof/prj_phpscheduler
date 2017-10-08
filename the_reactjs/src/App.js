import React, { Component } from "react";
import { Router, Route, browserHistory } from "react-router" 
import Home from "./components/Home";
import "./App.css";

class App extends Component {
    render() {
        return (
            <Home/>
        )//return
    }//render
}//App

export default App;
    
  