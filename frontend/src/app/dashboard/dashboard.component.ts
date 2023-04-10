import { Component, OnInit, ViewChild  } from '@angular/core';
import { UserService } from '../service/user.service';
import { NgForm } from '@angular/forms';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Router } from '@angular/router';
import { AgGridAngular } from 'ag-grid-angular';
import { CellClickedEvent, ColDef, GridReadyEvent,GridApi } from 'ag-grid-community';
import { Observable } from 'rxjs';
import { CellCustomeComponent } from '../cell-custome/cell-custome.component';
import { Products } from '../model/product';



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
  gridApi: any;
  gridColumnApi: any;
  showmuliDeletebtn: any;
  searchValues: any;
  nodes : any=[];
  node: any={};
  rowData: any=[];
  constructor(private _userService:UserService,private router: Router,private http: HttpClient) {

  }

  ngOnInit(): void {
  	this.getAllCsvlist();

  }
    
    columnDefs: ColDef[] = [
        { field: 'id', sortable: true,filter: true,maxWidth: 220,headerCheckboxSelection: true,
      checkboxSelection: true,
      showDisabledCheckboxes: true, },
        { field: 'name', sortable: true ,filter: true, maxWidth: 220},
        { field: 'state', sortable: true,filter: true, maxWidth: 220 },
        { field: 'zip', sortable: true,filter: true,maxWidth: 140 },
        { field: 'amount', sortable: true,filter: true, maxWidth: 120 },
        { field: 'qty', sortable: true, filter: true, maxWidth: 140},
        { field: 'item', sortable: true,filter: true, maxWidth: 120 },
        { headerName: "Action", field:'id',
        cellRendererFramework:CellCustomeComponent}
    ];


    // DefaultColDef sets props common to all Columns
     public defaultColDef: ColDef = {
       sortable: true,
       filter: true,
     };


   // load data from server
   onGridReady(params: any) {
     this.gridApi=params.api;
     this.gridColumnApi = params.columnApi;
   }
    
   // get all product lists
   async getAllCsvlist() {
    this._userService.getAllData().subscribe((data : any) => {
      if (data != null && data.details != null) {
        var resultData = data.details;
        if (resultData) {
          //this.userlist = resultData;
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
  
  // delete multipe row
  onDeleteRow()
  {
     var selectedData = this.gridApi.getSelectedRows();
     if(confirm("Are you sure to delete it ")) {
        if(selectedData.length>0){
            const productlist: Products[]=selectedData;
            const product_ids = productlist.map(node=> node.id);
            this._userService.deleteUser(product_ids).subscribe(res=>{
              this.data = res;
               if(this.data.status == 200){
                  this.userStatus=1;
                  this.userMessage = this.data.msg;
                  setTimeout(() => 
                  {
                     window.location.reload();
                  },
                  1000);
              }else{
                 this.userStatus=2;
                 this.userMessage = this.data.msg;
              }
              
            },
            (error: any) => { });
      }
    }
  }

  onRowSelected(event:any){
     var selectedData = this.gridApi.getSelectedRows();
     this.showmuliDeletebtn=0;
      if(selectedData.length>0){
          this.showmuliDeletebtn=1;
      }
   }

   quickSearch(){
     this.gridApi.setQuickFilter(this.searchValues);
   }



}

