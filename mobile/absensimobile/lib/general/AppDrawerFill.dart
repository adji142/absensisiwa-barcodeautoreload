import 'package:absensimobile/main.dart';
import 'package:absensimobile/pages/absensipage.dart';
import 'package:absensimobile/pages/jadwal.dart';
import 'package:absensimobile/pages/profile.dart';
import 'package:absensimobile/shared/sharedprefrence.dart';
import 'package:flutter/material.dart';
import 'package:absensimobile/shared/Session.dart';
import 'package:absensimobile/model/Auth.dart';

class AppDrawerFill {
  final Session? sess;
  AppDrawerFill(this.sess);

  List<Widget> getDrawerOption(BuildContext context) {
    List<Widget> widgetData = [];

    widgetData.add(
      UserAccountsDrawerHeader(
        accountName: Text(
          this.sess!.NamaUser,
          style: TextStyle(fontSize: this.sess!.width * 4),
        ), 
        accountEmail: Text(
          this.sess!.Email,
          style: TextStyle(fontSize: this.sess!.width * 3),
        ),
        currentAccountPicture: CircleAvatar(
          child: Icon(
            Icons.person,
            size: 48,
          ),
          backgroundColor: Colors.white,
        ),
        arrowColor: Theme.of(context).primaryColorLight,
        otherAccountsPictures: <Widget>[],
      )
    );

    if(this.sess!.roleID == 3){
      widgetData.add(ListTile(
        leading: Icon(Icons.calendar_month),
        title: Text(
          "Jadwal",
          style: TextStyle(
            fontFamily: "Montserrat",
            fontWeight: FontWeight.bold
          ),
        ),
        onTap: (){
          Navigator.push(context, MaterialPageRoute(builder: (context)=>JadwalPage(this.sess)));
        },
      ));

      widgetData.add(ListTile(
        leading: Icon(Icons.fingerprint),
        title: Text(
          "Absensi",
          style: TextStyle(
            fontFamily: "Montserrat",
            fontWeight: FontWeight.bold
          ),
        ),
        onTap: (){
          Navigator.push(context, MaterialPageRoute(builder: (context)=>AbsensiPage(this.sess)));
        },
      ));

      widgetData.add(ListTile(
        leading: Icon(Icons.person_4_outlined),
        title: Text(
          "Profile",
          style: TextStyle(
            fontFamily: "Montserrat",
            fontWeight: FontWeight.bold
          ),
        ),
        onTap: (){
          Navigator.push(context, MaterialPageRoute(builder: (context)=>ProfilePage(this.sess)));
        },
      ));
    }

    widgetData.add(ListTile(
        leading: Icon(Icons.logout),
        title: Text(
          "Logout",
          style: TextStyle(
            fontFamily: "Montserrat",
            fontWeight: FontWeight.bold
          ),
        ),
        onTap: (){
          SharedPreference().removeKey("accountInfo");
          Navigator.pushReplacement(context,MaterialPageRoute(builder: (context) => const MyApp()));
        },
      ));

    return widgetData;
  }
}
