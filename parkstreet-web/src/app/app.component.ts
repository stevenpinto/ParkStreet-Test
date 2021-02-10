import { HttpClient } from '@angular/common/http';
import { Component } from '@angular/core';
import { NgSelectConfig } from '@ng-select/ng-select';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {

  private static TM_LAST_MONTH_2_DATE = 1;
  private static TM_THIS_MONTH = 2;
  private static TM_THIS_YEAR = 3;
  private static TM_LAST_YEAR = 4;

  public title = 'Invoice Report Test';
  private baseUrl = 'http://localhost:8000/api';
  private gridApi;
  private gridColumnApi;
  public columnDefs;
  private sortingOrder;
  public products;
  public clients;
  public timeMeasures;
  public selectedTimeMeasure = null;
  public selectedProduct = null;
  public selectedClient = null;

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

    this.timeMeasures = [
      { value: AppComponent.TM_LAST_MONTH_2_DATE, name: 'Last Month To Date' },
      { value: AppComponent.TM_THIS_MONTH, name: 'This Month' },
      { value: AppComponent.TM_THIS_YEAR, name: 'This Year' },
      { value: AppComponent.TM_LAST_YEAR, name: 'Last Year' }
    ];

    this.http.get(`${this.baseUrl}/products`)
    .subscribe(data => {
      this.products = data;
    });

    this.http.get(`${this.baseUrl}/clients`)
    .subscribe(data => {
      this.clients = data;
    });

  }
  onGridReady(params) {
    this.gridApi = params.api;
    this.gridColumnApi = params.columnApi;
    this.fetchInvoicesList();
  }
  fetchInvoicesList() {
    let reportUrl = `${this.baseUrl}/invoices/report/?`

    if (!!this.selectedClient) {
      reportUrl += `clientId=${this.selectedClient}&`;
    }

    if (!!this.selectedProduct) {
      reportUrl += `productId=${this.selectedProduct}&`;
    }

    switch (this.selectedTimeMeasure) {
      case AppComponent.TM_LAST_MONTH_2_DATE:
        // TODO: add moment to get fromDate & toDate
        // TODO: add param to reportURL
        break;
      case AppComponent.TM_THIS_MONTH:
        // TODO: add moment to get fromDate & toDate
        // TODO: add param to reportURL
        break;
      case AppComponent.TM_THIS_YEAR:
        // TODO: add moment to get fromDate & toDate
        // TODO: add param to reportURL
        break;
      case AppComponent.TM_LAST_YEAR:
        // TODO: add moment to get fromDate & toDate
        // TODO: add param to reportURL
        break;
      default:
        break;
    }

    this.http.get(`${reportUrl}`)
    .subscribe(data => {
      this.gridApi.setRowData(data);
    });
  }
}
