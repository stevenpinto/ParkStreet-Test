import axios from 'axios';
import { useState } from 'react';
import './app.css';
import { trackPromise, usePromiseTracker } from 'react-promise-tracker';
import { useClientOptions, useInvoiceList } from './hooks/hooks';
import Loader from './components/loader';
import ProductList from './components/product-list';
import { relativeDateOptions } from './options/options';

function App() {

  const { promiseInProgress } = usePromiseTracker();
  const [products, setProducts] = useState([]);
  const [relativeDate, setRelativeDate] = useState('');
  const [productId, setProductId] = useState('');
  const [clientId, setClientId] = useState('');
  const clients = useClientOptions();
  const items = useInvoiceList(productId, clientId, relativeDate);

  const handleChangeClient = (e) => {

    setClientId(e.target.value);

    trackPromise(
      axios.post('http://localhost:8000/products_by_client/', {
        'client_id': e.target.value
      })
        .then(function (response) {
          if (response.data) {
            setProducts(response.data);
            setProductId('');
          }
        })
        .catch(function (error) {
          console.log(error);
        })
    )
  }

  return (
    <div className="container">
      <h1 className="title">Invoices</h1>
      <div className="filters">
        <select className="select" value={relativeDate} onChange={(e) => setRelativeDate(e.target.value)}>
          <option value="">Relative date</option>
          {relativeDateOptions.map((option) => (
            <option value={option.value} key={option.value}>{option.label}</option>
          ))}
          
        </select>
        <select className="select" value={clientId} onChange={handleChangeClient}>
          <option value="">Client</option>
          {clients.map((client) => (
            <option value={client.client_id} key={client.client_id}>{client.client_id}</option>
          ))}
        </select>
        {clientId &&
          <select className="select" value={productId} onChange={(e) => setProductId(e.target.value)}>
            <option value="">Product</option>
            {products.map((product) => (
              <option value={product.product_id} key={product.product_id}>{product.product_description}</option>
            ))}
          </select>
        }
      </div>

      <ProductList items={items} />

      {items.length === 0 && <p className="no-entries">No invoices were found.</p>}
      <Loader loading={promiseInProgress} />
    </div>
  );
}

export default App;
