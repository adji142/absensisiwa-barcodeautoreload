import 'package:absensimobile/main.dart';
import 'package:absensimobile/pages/absensipage.dart';
import 'package:absensimobile/pages/jadwal.dart';
import 'package:absensimobile/pages/profile.dart';
import 'package:absensimobile/shared/dialog.dart';
import 'package:absensimobile/shared/sharedprefrence.dart';
import 'package:flutter/material.dart';
import 'package:absensimobile/shared/Session.dart';
import 'package:absensimobile/model/Auth.dart';

class AppDrawerFill {
  final Session? sess;
  AppDrawerFill(this.sess);

  TextEditingController _Password = TextEditingController();
  TextEditingController _PasswordBaru = TextEditingController();
  TextEditingController _PasswordBaru2 = TextEditingController();
  bool obsecurepass = true;
  bool obsecurepassbaru = true;
  bool obsecurepassbaru2 = true;
// <Map<String, dynamic>
  void _showDialog(BuildContext ParentContext) {
    showDialog(
      context: ParentContext,
      builder: (BuildContext context) {
        return AlertDialog(
          title: Text('Ganti Password'),
          content: StatefulBuilder(
            builder: (BuildContext context, StateSetter setState) {
              return Column(
                mainAxisSize: MainAxisSize.min,
                children: [
                  Row(
                    mainAxisSize: MainAxisSize.max,
                    children: [
                      Container(
                        width: this.sess!.width * 45,
                        child:TextField(
                          autofocus: true,
                          obscureText: obsecurepass,
                          controller: _Password,
                          decoration: InputDecoration(hintText: "Password Lama"),
                        ),
                      ),
                      Container(
                        width: this.sess!.width * 15,
                        child:GestureDetector(
                          child: Icon(obsecurepass ? Icons.visibility_off : Icons.visibility),
                          onTap: (){
                            setState((){
                              obsecurepass = !obsecurepass;
                            });
                          },
                        )
                      )
                      
                    ],
                  ),

                  Row(
                    mainAxisSize: MainAxisSize.max,
                    children: [
                      Container(
                        width: this.sess!.width * 45,
                        child:TextField(
                          autofocus: true,
                          obscureText: obsecurepassbaru,
                          controller: _PasswordBaru,
                          decoration: InputDecoration(hintText: "Password Baru"),
                        ),
                      ),
                      Container(
                        width: this.sess!.width * 15,
                        child:GestureDetector(
                          child: Icon(obsecurepass ? Icons.visibility_off : Icons.visibility),
                          onTap: (){
                            setState((){
                              obsecurepassbaru = !obsecurepassbaru;
                            });
                          },
                        )
                      )
                      
                    ],
                  ),

                  Row(
                    mainAxisSize: MainAxisSize.max,
                    children: [
                      Container(
                        width: this.sess!.width * 45,
                        child:TextField(
                          autofocus: true,
                          obscureText: obsecurepassbaru2,
                          controller: _PasswordBaru2,
                          decoration: InputDecoration(hintText: "Ulangi Password Baru"),
                        ),
                      ),
                      Container(
                        width: this.sess!.width * 15,
                        child:GestureDetector(
                          child: Icon(obsecurepass ? Icons.visibility_off : Icons.visibility),
                          onTap: (){
                            setState((){
                              obsecurepassbaru2 = !obsecurepassbaru2;
                            });
                          },
                        )
                      )
                      
                    ],
                  )
                ],
              );
            }
          ),
          actions: [
            TextButton(
              child: Text("Simpan"),
              onPressed: (){
                if (_Password.text != "" && _PasswordBaru.text != "" && _PasswordBaru2.text != "") {
                  Map oParam() {
                    return {
                      "email"         : this.sess!.Email.toString(),
                      "password"      : _Password.text.toString(),
                      "password_new"  : _PasswordBaru.text.toString(),
                      "password_new2" : _PasswordBaru2.text.toString(),
                    };
                  }

                  var tmp = Auth(sess: this.sess, Parameter: oParam()).gantiPassword().then((value) async{
                    if (value['success'].toString() == "true") {
                      await messageBox(context: context, title: "Informasi", message: "Berhasil Mengganti Password, Silahkan Login Ulang").then((value){
                        SharedPreference().removeKey("accountInfo");
                        Navigator.pushReplacement(context,MaterialPageRoute(builder: (context) => const MyApp()));
                      });
                    }
                  });
                }
                else{
                  messageBox(context: context, title: "Informasi", message: "Data Tidak Lengkap");
                }
              }, 
            )
          ],
        );
      }
    );
  }

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
        leading: Icon(Icons.password),
        title: Text(
          "Ganti Password",
          style: TextStyle(
            fontFamily: "Montserrat",
            fontWeight: FontWeight.bold
          ),
        ),
        onTap: (){
          _showDialog(context);
        },
      ));

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
