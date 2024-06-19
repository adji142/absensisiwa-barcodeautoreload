import 'dart:async';

import 'package:absensimobile/general/AppDrawerFill.dart';
import 'package:absensimobile/model/Absensi.dart';
import 'package:absensimobile/model/Jadwal.dart';
import 'package:absensimobile/shared/Session.dart';
import 'package:absensimobile/shared/dialog.dart';
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';

class DashboardPage extends StatefulWidget {
  final Session? sess;
  const DashboardPage(this.sess, {super.key});

  @override
  _DashboardPageState createState() => _DashboardPageState();
}

class _DashboardPageState extends State<DashboardPage> {
  
  final GlobalKey<State> _keyLoader = GlobalKey<State>();

  DateTime selectedDate = DateTime.now();
  String _Kelas_id = "";
  String _Siswa_id = "";
  String _DayName = "";
  @override
  void initState() {
    
    super.initState();
  }

  @override
  void dispose() {
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    _DayName = DateFormat("EEEE").format(selectedDate);
    if(this.widget.sess!.DataSiswa.length > 0){
      _Kelas_id = this.widget.sess!.DataSiswa[0]["Kelas_id"].toString();
      _Siswa_id = this.widget.sess!.DataSiswa[0]["id"].toString();
    }
    // print(this.widget.sess!.Token);
    Map oParam() {
      return {"RecordOwnerID": this.widget.sess!.RecordOwnerID};
    }
    // print(oParam());
    return Scaffold(
        appBar: AppBar(
          title: Text("Absensi Siswa"),
        ),
        drawer: Drawer(
          child: ListView(
            children: AppDrawerFill(this.widget.sess).getDrawerOption(context),
          ),
        ),
        body: Padding(
          padding: EdgeInsets.all(this.widget.sess!.width * 2),
          child: Column(
            children: [
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceAround,
                children: [
                  Padding(
                    padding: EdgeInsets.all(this.widget.sess!.width * 2),
                    child:Container(
                      width: this.widget.sess!.width * 40,
                      height: this.widget.sess!.width * 40,
                      color: Colors.red,
                      child: Column(
                        children: [
                          Padding(
                            padding: EdgeInsets.only(
                              left: this.widget.sess!.width *2,
                              right: this.widget.sess!.width *2,
                              top: this.widget.sess!.width *2
                            ),
                            child: Text(
                              "Jumlah Mapel",
                              style: TextStyle(
                                fontSize: this.widget.sess!.width * 5,
                                color: Colors.white,
                                fontWeight: FontWeight.bold
                              ),
                            ),
                          ),
                          Padding(
                            padding: EdgeInsets.only(
                              left: this.widget.sess!.width *2,
                              right: this.widget.sess!.width *2
                            ),
                            child: Text(
                              "Hari " + Jadwal().convertDayName(_DayName),
                              style: TextStyle(
                                fontSize: this.widget.sess!.width * 4,
                                color: Colors.white,
                                fontWeight: FontWeight.bold
                              ),
                            ),
                          ),
                          Padding(
                            padding: EdgeInsets.only(
                              left: this.widget.sess!.width *2,
                              right: this.widget.sess!.width *2,
                            ),
                            child: FutureBuilder(
                              future: Jadwal(sess: this.widget.sess, Parameter: {"Hari":Jadwal().convertDayName(_DayName), "kelas_id": _Kelas_id }).getJadwal(), 
                              builder: (context, snapshot){
                                if(snapshot.hasError){
                                  return Container(
                                    child: Center(
                                      child: Text(snapshot.error.toString()),
                                    ),
                                  );
                                }
                                else if(snapshot.hasData){
                                  return Text(
                                    snapshot.data!["data"].length.toString(),
                                    style: TextStyle(
                                      fontSize: this.widget.sess!.width * 15,
                                      color: Colors.white,
                                      fontWeight: FontWeight.bold
                                    ),
                                  );
                                }
                                else{
                                  return Text(
                                    "0",
                                    style: TextStyle(
                                      fontSize: this.widget.sess!.width * 15,
                                      color: Colors.white,
                                      fontWeight: FontWeight.bold
                                    ),
                                  );
                                }
                              }
                            )
                          )
                        ],
                      ),
                    ),
                  ),
                  
                  Padding(
                    padding: EdgeInsets.all(this.widget.sess!.width * 2),
                    child:Container(
                      width: this.widget.sess!.width * 40,
                      height: this.widget.sess!.width * 40,
                      color: Colors.green,
                      child: Column(
                        children: [
                          Padding(
                            padding: EdgeInsets.only(
                              left: this.widget.sess!.width *2,
                              right: this.widget.sess!.width *2,
                              top: this.widget.sess!.width *2
                            ),
                            child: Text(
                              "Sudah Absen",
                              style: TextStyle(
                                fontSize: this.widget.sess!.width * 5,
                                color: Colors.white,
                                fontWeight: FontWeight.bold
                              ),
                            ),
                          ),
                          Padding(
                            padding: EdgeInsets.only(
                              left: this.widget.sess!.width *2,
                              right: this.widget.sess!.width *2
                            ),
                            child: Text(
                              "Hari " + Jadwal().convertDayName(_DayName),
                              style: TextStyle(
                                fontSize: this.widget.sess!.width * 4,
                                color: Colors.white,
                                fontWeight: FontWeight.bold
                              ),
                            ),
                          ),
                          Padding(
                            padding: EdgeInsets.only(
                              left: this.widget.sess!.width *2,
                              right: this.widget.sess!.width *2,
                            ),
                            child: FutureBuilder(
                              future: Absensi(this.widget.sess, {"TglAwal":selectedDate.toString().split(' ')[0], "TglAkhir":selectedDate.toString().split(' ')[0], "siswa_id": _Siswa_id }).getAbsensi(), 
                              builder: (context, snapshot){
                                if(snapshot.hasError){
                                  return Container(
                                    child: Center(
                                      child: Text(snapshot.error.toString()),
                                    ),
                                  );
                                }
                                else if(snapshot.hasData){
                                  return Text(
                                    snapshot.data!["data"].length.toString(),
                                    style: TextStyle(
                                      fontSize: this.widget.sess!.width * 15,
                                      color: Colors.white,
                                      fontWeight: FontWeight.bold
                                    ),
                                  );
                                }
                                else{
                                  return Text(
                                    "0",
                                    style: TextStyle(
                                      fontSize: this.widget.sess!.width * 15,
                                      color: Colors.white,
                                      fontWeight: FontWeight.bold
                                    ),
                                  );
                                }
                              }
                            )
                          )
                        ],
                      ),
                    ),
                  ),
                ],
              ),
              Padding(
                padding: EdgeInsets.all(this.widget.sess!.width * 2),
                child: Container(
                  width: double.infinity,
                  height: this.widget.sess!.hight * 65,
                  child: FutureBuilder(
                    future: Absensi(this.widget.sess, {"Tanggal" : selectedDate.toString().split(" ")[0], "Hari" : Jadwal().convertDayName(_DayName), "Siswa_ID" : _Siswa_id}).getDashbiard(), 
                    builder: (context, snapshot){
                      if (snapshot.hasError) {
                        return Container(
                          child: Center(
                            child: Text(snapshot.error.toString()),
                          ),
                        );
                      }
                      else if(snapshot.hasData){
                        return ListView.builder(
                          itemCount: snapshot.data != null ? snapshot.data!["data"].length : 0,
                          itemBuilder: (context, index){
                            return Card(
                              child: ListTile(
                                leading: CircleAvatar(
                                  backgroundColor: snapshot.data!["data"][index]["barcode_id"] == "" ? Colors.red : Colors.green,
                                  child: snapshot.data!["data"][index]["barcode_id"] == "" ?
                                          Icon(Icons.cancel_outlined, color: Colors.white,):
                                          Icon(Icons.done_all_outlined, color: Colors.white,),
                                ),
                                title: Text(
                                  snapshot.data!["data"][index]["NamaMataPelajaran"] + " - " + snapshot.data!["data"][index]["Jam"]
                                ),
                                subtitle: Text(
                                  snapshot.data!["data"][index]["FormatedAbsensiDate"]
                                ),
                              ),
                            );
                          }
                        );
                      }
                      else{
                        return Container(
                          child: Center(
                            child: Text("no Data"),
                          ),
                        );
                      }
                    }
                  )
                ),
              )
            ],
          )
        ),
      );
  }

  Future _refreshData() async {
    setState(() {});
    Completer<Null> completer = Completer<Null>();
    Future.delayed(Duration(seconds: 1)).then((_) {
      completer.complete();
    });
    return completer.future;
  }
}
