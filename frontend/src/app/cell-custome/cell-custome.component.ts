import { Component, OnInit, ViewChild  } from '@angular/core';
import { UserService } from '../service/user.service';
import { NgForm } from '@angular/forms';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Router } from '@angular/router';
@Component({
  selector: 'app-cell-custome',
  templateUrl: './cell-custome.component.html',
  styleUrls: ['./cell-custome.component.less']
})
export class CellCustomeComponent implements OnInit {

  data: any;
  params: any;
  userMessage: any;
  userStatus: any;
  constructor(private _userService:UserService,private http: HttpClient, private router: Router) {}

  agInit(params: any) {
    this.params = params;
    this.data = params.value;
  }

  ngOnInit() {}

  editRow() {
    let rowData = this.params;
    let i = rowData.rowIndex;
    this.router.navigate(['EditUser',rowData.value]);
  }

  viewRow() {
    let rowData = this.params;
  }
 // delete user function
  deleteUser() {
    if(confirm("Are you sure to delete it ")) {
        this._userService.deleteUser(this.params.value).subscribe(res=>{
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
