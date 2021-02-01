export default function ProductList(props) {
    const items = props.items;
    return (
        <table className="table">
            <thead>
                <tr>
                    <th>Invoice number</th>
                    <th>Invoice date</th>
                    <th>Product description</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                {items.map((item, index) => {
                    const date = new Date(item.invoice_date);
                    return (
                        <tr key={index}>
                            <td>
                                {item.invoice_num}
                            </td>
                            <td>
                                {`${date.getUTCMonth()+1}/${date.getUTCDay()}/${date.getUTCFullYear()}`}
                            </td>
                            <td>
                                {item.product_description}
                            </td>
                            <td>
                                {item.qty}
                            </td>
                            <td>
                                {`$${parseFloat(item.price).toFixed(2)}`}
                            </td>
                            <td>
                                {`$${parseFloat(item.total).toFixed(2)}`}
                            </td>
                        </tr>
                    );
                }
                )}
            </tbody>
        </table>
    );
}