import React, { Component } from "react";
import { Navbar, Grid, Row, Col } from "react-bootstrap";
import ProductList from "./components/ProductList";
import ShoppingCart from "./components/ShoppingCart";
import "./App.css";

console.log("APP")

class App extends Component {
    render() {
        console.log("APP.App.render")
        return (
            <div>
                <Navbar inverse staticTop>
                    <Navbar.Header>
                        <Navbar.Brand>
                            <a href="#">Ecommerce</a>
                        </Navbar.Brand>
                    </Navbar.Header>
                </Navbar>

                <Grid>
                    <Row>
                        <Col sm={8}>
                            <ProductList />
                        </Col>
                        <Col sm={4}>
                            <ShoppingCart />
                        </Col>
                    </Row>
                </Grid>
                <footer class="footer">
                    <div class="container">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a rel="nofollow"  class="btn btn-block" href="/"> 
                                    <span class="fa fa-home"></span>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a rel="nofollow" class="btn btn-block btn-social btn-github" href="https://github.com/eacevedof/prj_phpscheduler"> 
                                    <span class="fa fa-github"></span>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a rel="nofollow"  href="https://twitter.com/eacevedof" class="btn btn-block btn-social btn-twitter"> 
                                    <span class="fa fa-twitter"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </footer>                
            </div>
        ) //return
    }//render
}//App

export default App;