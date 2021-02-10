import { HttpClient } from '@angular/common/http';
import { Component } from '@angular/core';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  public title = 'Invoice Report Test';
  private gridApi;
  private gridColumnApi;
  public columnDefs;
  private sortingOrder;

  constructor(private http: HttpClient) {
    this.columnDefs = [
      { headerName: 'Invoice Num', field: 'invoice_num', width: 150, sortable: true, sortingOrder: ['asc', 'desc'] },
      { headerName: 'Invoice Date', field: 'invoice_date', width: 150, sortable: true, sortingOrder: ['asc', 'desc'] },
      { headerName: 'Client Name', field: 'client_name', width: 150, sortable: true, sortingOrder: ['asc', 'desc'], filter: true },
      { headerName: 'Product', field: 'product', width: 150, sortable: true, sortingOrder: ['asc', 'desc'], filter: true },
      { headerName: 'Quantity', field: 'qty', width: 150, sortable: true, sortingOrder: ['asc', 'desc'] },
      { headerName: 'Price', field: 'price', width: 150, sortable: true, sortingOrder: ['asc', 'desc'] },
      { headerName: 'Total', field: 'total', width: 150, sortable: true, sortingOrder: ['asc', 'desc'] },
    ];

  }
  onGridReady(params) {
    this.gridApi = params.api;
    this.gridColumnApi = params.columnApi;
    this.http.get('http://localhost:8000/api/invoices/report')
    .subscribe(data => {
      this.gridApi.setRowData(data);
    });
  }
}
