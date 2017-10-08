import React, { Component } from "react";
import { Navbar, Grid, Row, Col } from "react-bootstrap";
import ProductList from "./components/ProductList";
import ShoppingCart from "./components/ShoppingCart";
import ElementFooter from "./components/elements/ElementFooter";
import "./App.css";

console.log("APP")

class App extends Component {
    render() {
        console.log("APP.App.render")
        return (
            <div className="container-fluid">
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
                <ElementFooter/>
            </div>
        ) //return
    }//render
}//App

export default App;