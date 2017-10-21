Button.onClick() : => 
    oDispatch.fnAddtoCart(oProduct) : => //PRODUCTLIST.fnMapDispatchToProps.oDispatch.fnAddToCart
        fnAcAddtoCart(oProduct) : => //ACTIONCREATORS.fnAcAddToCart 
            fnDispatch(oAction) : => //PRODUCTLIST.fnLogger(oAction)
                fnLogger(oStore,fnNext,oAction) => //STORE.fnLogger
                    //REDUCERS combinados
                    fnStoreCart(arState,oAction) => //STORE.fnStoreCart
                    fnStoreProducts(arState,oAction) => //STORE.fnStoreProducts
                        


PRODUCTLIST.fnMapDispatchToProps.oDispatch.fnAddToCart.fnDispatch ƒ (oAction) {
//console.log("fnLogger.oStore: ",oStore," | fnLogger.fnNext: ",fnNext," | fnLogger.oAction: ",oAction)
console.log("STORE.fnLogger dispatching oAction: ", oAction…
ProductList.js:68 PRODUCTLIST.fnMapDispatchToProps.oDispatch.fnAddToCart
actionCreators.js:11 ACTIONCREATORS.fnAcAddToCart return oAction+oProduct
store.js:47 STORE.fnLogger dispatching oAction:  {type: "ADD_TO_CART", product: {…}}
store.js:48 STORE.fnLogger fnNext:  ƒ (action) {
    if (typeof action === 'function') {
        return action(dispatch, getState, extraArgument);
    }
    return next(action);
}
store.js:31 STORE.fnStoreCart.oAction.type ADD_TO_CART
store.js:32 STORE.fnStoreCart.arState []
store.js:19 STORE.fnStoreProducts.oAction.type ADD_TO_CART
store.js:20 STORE.fnStoreProducts.arState (3) [{…}, {…}, {…}]
ProductList.js:49 PRODUCTLIST.fnMapStateToProps return oStateNew con arProducts
ShoppingCart.js:57 SHOPPINGCART.fnMapStateToProps return oStateNew con arCart
store.js:50 STORE.fnLogger oStore.getstate() next state:  {arCart: Array(1), arProducts: Array(3)}
store.js:51 STORE.fnLogger oResult:  {type: "ADD_TO_CART", product: {…}}
ShoppingCart.js:25 SHOPPINGCART.fnRenderShoppingCart