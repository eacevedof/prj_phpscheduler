import React from "react";
import { Button, Glyphicon } from "react-bootstrap";
import { AcCart } from "../actions/ac_cart"
import { AcProduct } from "../actions/ac_product"
import { connect } from "react-redux"

console.log("PRDUCTLIST")

const oStyles = {
    products: {
        display: 'flex',
        alignItems: 'stretch',
        flexWrap: 'wrap'
    },
    product: {
        width: '220px',
        marginLeft: 10,
        marginRight: 10
    }
}//oStyles

const fnProductList = ({ arProducts, fnAddToCart }) => {
    console.log("PRODUCTLIST.fnProductList.render()")
    console.log("PRODUCTLIST.fnProductList: arProducts",arProducts)
    console.log("PRODUCTLIST.fnProductList: fnAddToCart",fnAddToCart)
    
    return (
        <div style={oStyles.products}>
            {arProducts.map(oProduct =>
                <div className="thumbnail" style={oStyles.product} key={oProduct.id}>
                    <img src={oProduct.image} alt={oProduct.name} />
                    <div className="caption">
                        <h4>{oProduct.name}</h4>
                        <p>
                            <Button bsStyle="primary" onClick={() => fnAddToCart(oProduct)} role="button" disabled={oProduct.inventory <= 0}>
                                ${oProduct.price} <Glyphicon glyph="shopping-cart" />
                            </Button>
                        </p>
                    </div>
                </div>)
            }
        </div>
    )//render
}//fnProductList

const fnMapStateToProps = (oState)=>{
    console.log("PRODUCTLIST.fnMapStateToProps return oStateNew con arProducts")
    let oStateNew = {
        arProducts : oState.arProducts
    }
    return oStateNew
}//fnMapStateToProps

const fnMapDispatchToProps = fnDispatch => {
    console.log("PRODUCTLIST.fnMapDispatchToProps devuelve oDispatch")
    let oDispatch = {
        fnLoadProducts : arProducts => {
            console.log("PRODUCTLIST.fnMapDispatchToProps.oDispatch.fnLoadProducts")
            let oAction = AcProduct.load(arProducts)
            fnDispatch(oAction)
        },
        fnAddToCart : oProduct => {
            console.log("PRODUCTLIST.fnMapDispatchToProps.oDispatch.fnAddToCart")
            let oAction = AcCart.add(oProduct)
            fnDispatch(oAction)
        }
    }
    return oDispatch
}//fnMapDispatchToProps

export default connect(fnMapStateToProps,fnMapDispatchToProps)(fnProductList);