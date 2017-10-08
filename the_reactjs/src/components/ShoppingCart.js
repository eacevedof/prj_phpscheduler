import React from "react";
import { Panel, Table, Button, Glyphicon } from "react-bootstrap"
import {fnAcRemoveFromCart} from "../actions/creator"
import {connect} from "react-redux"

console.log("SHOPPINGCART")

const oStyles = {
    footer: {
        fontWeight: 'bold'
    }
}//oStyles


const fnRenderShoppingCart = ({arCart,fnRemoveFromCart})=>{
    console.log("SHOPPINGCART.fnRenderShoppingCart")
    return (
        <Panel header="Shopping Cart">
            <Table fill>
                <tbody>
                  {arCart.map(oProduct =>
                    <tr key={oProduct.id}>
                        <td>{oProduct.name}</td>
                        <td className="text-right">${oProduct.price}</td>
                        <td className="text-right">
                            <Button bsSize="xsmall" bsStyle="danger" onClick={() => fnRemoveFromCart(oProduct)}>
                                <Glyphicon glyph="trash" />
                            </Button>
                        </td>
                    </tr>
                  )}
                </tbody>
                <tfoot>
                    <tr>
                        <td colSpan="4" style={oStyles.footer}>
                          Total: ${arCart.reduce((fSum,oProduct) => fSum + oProduct.price, 0)}
                        </td>
                    </tr>
                </tfoot>
            </Table>
        </Panel>
    )//return
    
}//fnRenderShoppingCart


const fnMapStateToProps = oState => {
    console.log("SHOPPINGCART.fnMapStateToProps return oStateNew con arCart")
    let oStateNew = {
        arCart: oState.arCart
    } 
    return oStateNew 
}//fnMapStateToProps

const fnMapDispatchToProps = fnDispatch => {
    console.log("SHOPPINGCART.fnMapDispatchToProps return oDispatch")
    let oDispatch = {
        fnRemoveFromCart : oProduct => {
            console.log("SHOPPINGCART.fnMapDispatchToProps.oDispatch.fnRemoveFromCart")
            let oAction = fnAcRemoveFromCart(oProduct)
            fnDispatch(oAction)
        }//removeFromCart 
    }//oDispatch
    return oDispatch 
}//fnMapDispatchToProps

export default connect(fnMapStateToProps,fnMapDispatchToProps)(fnRenderShoppingCart);