import {  Component, OnChanges, SimpleChanges  } from '@angular/core';
import { AppService } from '../../app.service';
import { NgForm } from '@angular/forms';


@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent {
 protected  bucket_name:string='';
 protected  bucket_vol:string='';
 protected  ball_name:string='';
 protected  ball_vol:string='';
 protected  bucket_msg :string='';
 protected  ball_msg :string='';
 protected  bucket_select :string='';
 protected  ball_select :string='';
protected options: any[] = [];
protected buckets_list: any[] = [];
protected suggested: any[] = [];
protected output_buckets: any[] = [];
protected extraBalls: any[] = [];
 public selectedOption: any;
 constructor(
    private appService: AppService
  ) {
    this.getBallsDetails();
    this.getBucketsDetails();

  }


public  ballSaveData(){
    this.ball_msg='';
    console.log("ball_vol",this.ball_vol);
    console.log("ball_name",this.ball_name);
    var data :any=[];
    data['ball_name']=this.ball_name;
    data['ball_vol']=this.ball_vol;
    this.appService.saveBall(data).subscribe(
    (response: any) => {
        console.log("RC",response);
        this.ball_msg= response.message;
        this.getBallsDetails();
      },
    error => {
        console.log("ERR",error);
        console.log("ERR2",error.error.error);
        this.ball_msg=error.error.error;
      });
}


public  bucketSaveData(){
    this.bucket_msg='';
    console.log("bucket_vol",this.bucket_vol);
    console.log("bucket_name",this.bucket_name);
    var data :any=[];
    data['bucket_name']=this.bucket_name;
    data['bucket_vol']=this.bucket_vol;
    this.appService.saveBucket(data).subscribe((response:any) => {
        console.log("RC",response);
        this.bucket_msg= response.message;
        this.getBucketsDetails();
      }, error => {
        console.log("ERR",error);
        console.log("ERR2",error.error.error);
        this.bucket_msg=error.error.error;
      });
}
public  ballDelete(){
    if (confirm("Do you really want to delete your Ball?")) {
    this.appService.deleteBall({"id":this.ball_select}).subscribe((response:any) => {
        console.log("RC",response);
      this.getBallsDetails();
      }, error => {
        console.log("ERR",error);
        console.log("ERR2",error.error.error);
      });
    }
}
public  bucketDelete(){
    if (confirm("Do you really want to delete your Bucket?")) {
    this.appService.deleteBucket({"id":this.bucket_select}).subscribe((response:any) => {
        console.log("RC",response);
       this.getBucketsDetails();
      }, error => {
        console.log("ERR",error);
        console.log("ERR2",error.error.error);
      });
    }
}

public getBallsDetails(){
    this.appService.getBalls([]).subscribe((response:any) => {
        console.log("RC",response);
        this.options= response;
      }, error => {
        console.log("ERR",error);
      });
}
public getBucketsDetails(){
    this.appService.getBuckets([]).subscribe((response:any) => {
        console.log("RC",response);
        this.buckets_list= response;
      }, error => {
        console.log("ERR",error);
      });
}

public checkBuckets(){
    var formData:any={};
    this.options.forEach((val) => {
        formData[val.name] = val.quantity;
      });
    this.appService.checkBuckets(formData).subscribe((response:any) => {
        console.log("RC",response);
        this.output_buckets= response.selected_buckets;
        this.extraBalls= response.extra_balls;
      }, error => {
        console.log("ERR",error);
      });

}
ngOnChanges(changes: any): void {
  }
}
