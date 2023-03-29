import { Component, OnInit, ViewChild  } from '@angular/core';
import { UserService } from '../service/user.service';
import { NgForm } from '@angular/forms';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Router } from '@angular/router';

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

  constructor(private _freeservice:UserService,private router: Router) {

  }

  ngOnInit(): void {
  	this.getAllCsvlist();

  }

   async getAllCsvlist() {
    this._freeservice.getAllData().subscribe((data : any) => {
      if (data != null && data.details != null) {
        var resultData = data.details;
        if (resultData) {
       
          this.userlist = resultData;

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

	deleteUser(item_id:any) {
    if(confirm("Are you sure to delete it ")) {
        this._freeservice.deleteUser(item_id).subscribe(res=>{
        this.data = res;
        
        if(this.data.status == 200){
            this.userStatus=1;
            this.userMessage = this.data.msg;
            setTimeout(() => 
            {
              this.router.navigateByUrl('/Home');
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

 


  AddUser() {
    this.router.navigate(['AddUser']);
  }


}

