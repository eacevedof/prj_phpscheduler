import React from "react";
import ReactDOM from "react-dom";
import App from "./App";
import oStore from "./store/store";
import {Provider} from "react-redux"
import {AcProduct} from "./actions/ac_product"
import "./index.css";

console.log("INDEX.Rreact: ",React)
console.log("INDEX.ReactDOM: ",ReactDOM)
console.log("INDEX.App: ",App)
console.log("INDEX.oStore: ",oStore)
console.log("INDEX.Provider: ",Provider)
console.log("INDEX.fnAcLoadProducts: ",AcProduct.load)

const fnProdDispatch = AcProduct.load()
//fnProdDispatch: fnDispatch => {..}
console.log("INDEX.fnProdDispatch: ",fnProdDispatch)
oStore.dispatch(fnProdDispatch)

ReactDOM.render(
    <Provider store={oStore}>
        <App />
    </Provider>,
    document.getElementById("root")
);
console.log("end index.js render")