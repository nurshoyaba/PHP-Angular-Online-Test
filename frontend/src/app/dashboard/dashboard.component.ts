import { Component, OnInit, ViewChild  } from '@angular/core';
import { UserService } from '../service/user.service';
import { NgForm } from '@angular/forms';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Router } from '@angular/router';
import { AgGridAngular } from 'ag-grid-angular';
import { CellClickedEvent, ColDef, GridReadyEvent } from 'ag-grid-community';
import { Observable } from 'rxjs';
import { CellCustomeComponent } from '../cell-custome/cell-custome.component';


@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.less']
})
export class DashboardComponent implements OnInit {
	
  userlist: any=[];
  data: any={};
  userMessage: any;
  userStatus: any;
  //rowData : any=[];
  // Data that gets displayed in the grid
  rowData: any=[];
  constructor(private _freeservice:UserService,private router: Router,private http: HttpClient) {

  }

  ngOnInit(): void {
  	this.getAllCsvlist();

  }
    
    columnDefs: ColDef[] = [
        { field: 'id', sortable: true,filter: true, },
        { field: 'name', sortable: true ,filter: true,},
        { field: 'state', sortable: true,filter: true, },
        { field: 'zip', sortable: true,filter: true, },
        { field: 'amount', sortable: true,filter: true, },
        { field: 'qty', sortable: true, filter: true,},
        { field: 'item', sortable: true,filter: true, },
        { headerName: "Action", field:'id',
        cellRendererFramework:CellCustomeComponent}
    ];


    // DefaultColDef sets props common to all Columns
     public defaultColDef: ColDef = {
       sortable: true,
       filter: true,
     };
 
 



   // Example load data from server
   onGridReady() {
     this.rowData = this.http
       .get('https://www.ag-grid.com/example-assets/row-data.json');
       console.log(this.rowData);
   }
    
   // get all product lists
   async getAllCsvlist() {
    this._freeservice.getAllData().subscribe((data : any) => {
      if (data != null && data.details != null) {
        var resultData = data.details;
        if (resultData) {
       
          this.userlist = resultData;
          this.rowData = resultData;

        }
      }
    },
    (error : any)=> {
        if (error) {
          if (error.status == 404) {
            if(error.error && error.error.message){
              this.userlist = [];
            }
          }
        }
      });
    }

	
  AddUser() {
    this.router.navigate(['AddUser']);
  }


}

