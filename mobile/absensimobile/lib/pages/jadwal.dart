import 'dart:async';

import 'package:absensimobile/model/Jadwal.dart';
import 'package:absensimobile/shared/Session.dart';
import 'package:absensimobile/shared/dialog.dart';
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';

class JadwalPage extends StatefulWidget {
  Session? session;
  JadwalPage(this.session);

  @override
  _JadwalPageState createState() => _JadwalPageState();
}

class _JadwalPageState extends State<JadwalPage> {
  final GlobalKey<State> _keyLoader = new GlobalKey<State>();
  TextEditingController _tglText = TextEditingController();
  
  DateTime selectedDate = DateTime.now();
  String _DayName = "";
  Map ? oParam;

  _selectDate(BuildContext context) async {
    final DateTime? picked = await showDatePicker(
      context: context,
      initialDate: selectedDate,
      firstDate: DateTime(2000),
      lastDate: DateTime(2025),
    );
    if (picked != null && picked != selectedDate)
      setState(() {
        selectedDate = picked.toLocal();
        //print(selectedDate);
        _DayName = DateFormat("EEEE").format(selectedDate);
        _tglText.text = selectedDate.toString();
      });
  }
  @override
  void initState() {
    super.initState();
    _DayName = DateFormat("EEEE").format(selectedDate);
  }

  @override
  Widget build(BuildContext context) {

    return Scaffold(
      appBar: AppBar(
        backgroundColor: Theme.of(context).primaryColor,
        foregroundColor: Colors.white,
        title: Text("Jadwal Pelajaran"),
      ),
      body: Stack(
        children: [
          Column(
            children: [
              Padding(
                padding: EdgeInsets.all(this.widget.session!.width * 2),
                child: SizedBox(
                  width: double.infinity,
                  height: this.widget.session!.hight * 10,
                  child: ListTile(
                    leading: Icon(
                      Icons.calendar_month
                    ),
                    title: Text(
                      "Tanggal",
                      style: TextStyle(
                        fontSize: this.widget.session!.width * 5,
                        fontWeight: FontWeight.bold
                      ),
                    ),
                    subtitle: Text(
                      selectedDate.toString().split(" ")[0],
                      style: TextStyle(
                        fontSize: this.widget.session!.width * 5,
                        fontWeight: FontWeight.bold,
                        color: Colors.red
                      ),
                    ),
                    onTap: (){
                      _selectDate(context);
                    },
                  ),
                ),
              ),
              Padding(
                padding: EdgeInsets.only(
                  left: this.widget.session!.width * 2,
                  right: this.widget.session!.width * 2
                ),
                child: ListTile(
                  leading: Icon(Icons.date_range_sharp),
                  title: Text(
                    Jadwal().convertDayName(_DayName),
                    style: TextStyle(
                      color: Colors.red,
                      fontSize: this.widget.session!.width * 5
                    ),
                  ),
                )
              ),
              Padding(
                padding: EdgeInsets.all(this.widget.session!.width * 2),
                child: SizedBox(
                  width: double.infinity,
                  height: this.widget.session!.hight * 65,
                  child: FutureBuilder(
                    future: Jadwal(sess: this.widget.session, Parameter: {"Hari":Jadwal().convertDayName(_DayName), "kelas_id": this.widget.session!.DataSiswa[0]["Kelas_id"].toString() }).getJadwal(), 
                    builder: (context, snapshot){
                      if(snapshot.hasError){
                        return Container(
                          child: Center(
                            child: Text(snapshot.error.toString()),
                          ),
                        );
                      }
                      else{
                        return RefreshIndicator(
                          onRefresh: _refreshData,
                          child: ListView.builder(
                            itemCount: snapshot.data != null ? snapshot.data!["data"].length : 0,
                            itemBuilder: (context, index){
                              return Card(
                                child: ListTile(
                                  leading: CircleAvatar(
                                    child: Text((index +1).toString()),
                                  ),
                                  title: Text(
                                    snapshot.data!["data"][index]["NamaMataPelajaran"] +" - " + snapshot.data!["data"][index]["NamaGuru"]
                                  ),
                                  subtitle: Text(
                                    snapshot.data!["data"][index]["Jam"]
                                  ),
                                ),
                              );
                            }
                          ), 
                        );
                      }
                    }
                  ),
                ),
              )
            ],
          )
        ],
      ),
    );
  }

  Future _refreshData() async{
      setState((){});

      Completer<Null> completer = Completer<Null>();
      Future.delayed(Duration(seconds: 1)).then( (_) {
        completer.complete();
      });
      return completer.future;
  }
  
}
