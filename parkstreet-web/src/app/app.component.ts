import { HttpClient } from '@angular/common/http';
import { Component } from '@angular/core';
import * as moment from 'moment';

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
      { headerName: 'Invoice Num', field: 'invoice_num', width: 120, sortable: true, sortingOrder: ['asc', 'desc'] },
      { headerName: 'Invoice Date', field: 'invoice_date', width: 120, sortable: true, sortingOrder: ['asc', 'desc'] },
      { headerName: 'Client Name', field: 'client_name', width: 180, sortable: true, sortingOrder: ['asc', 'desc'], filter: true },
      { headerName: 'Product', field: 'product', width: 300, sortable: true, sortingOrder: ['asc', 'desc'], filter: true },
      { headerName: 'Quantity', field: 'qty', width: 100, sortable: true, sortingOrder: ['asc', 'desc'] },
      { headerName: 'Price', field: 'price', width: 100, sortable: true, sortingOrder: ['asc', 'desc'], cellRenderer: (params) => this.currencyFormat(params.value) },
      { headerName: 'Total', field: 'total', width: 100, sortable: true, sortingOrder: ['asc', 'desc'], cellRenderer: (params) => this.currencyFormat(params.value) },
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

    if (!!this.selectedTimeMeasure) {
      let dateTo;
      let dateFrom;
      switch (this.selectedTimeMeasure) {
        case AppComponent.TM_LAST_MONTH_2_DATE:
          dateTo = moment();
          dateFrom = moment().subtract(1, 'month').startOf('month');
          break;
        case AppComponent.TM_THIS_MONTH:
          dateTo = moment();
          dateFrom = moment().startOf('month');
          break;
        case AppComponent.TM_THIS_YEAR:
          dateTo = moment();
          dateFrom = moment().startOf('year');
          break;
        case AppComponent.TM_LAST_YEAR:
          dateTo = moment().subtract(1, 'year').endOf('year');
          dateFrom = moment().subtract(1, 'year').startOf('year');
          break;
        default:
          dateTo = moment();
          dateFrom = null;
          break;
      }
      // Add params to reportURL
      dateFrom = (!!dateFrom) ? dateFrom.format('YYYY-MM-DD') : null;
      dateTo =  dateTo.format('YYYY-MM-DD');
      reportUrl += `dateFrom=${dateFrom}&dateTo=${dateTo}`;
    }

    this.http.get(`${reportUrl}`)
    .subscribe(data => {
      this.gridApi.setRowData(data);
    });
  }
  currencyFormat (value) {
    return '$' + value.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
  }
}
