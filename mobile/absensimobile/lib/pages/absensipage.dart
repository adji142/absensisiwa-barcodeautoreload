import 'dart:async';

import 'package:absensimobile/model/Absensi.dart';
import 'package:absensimobile/model/Jadwal.dart';
import 'package:absensimobile/shared/Session.dart';
import 'package:absensimobile/shared/dialog.dart';
import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutter_barcode_scanner/flutter_barcode_scanner.dart';
import 'package:intl/intl.dart';

class AbsensiPage extends StatefulWidget {
  Session? session;
  AbsensiPage(this.session);

  @override
  _AbsensiPageState createState() => _AbsensiPageState();
}

class _AbsensiPageState extends State<AbsensiPage> {
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

  Future<String> barcodeScan() async {
    String barcodeScanRes;
    // Platform messages may fail, so we use a try/catch PlatformException.
    try {
      barcodeScanRes = await FlutterBarcodeScanner.scanBarcode(
          '#ff6666', 'Cancel', true, ScanMode.QR);
      // print(barcodeScanRes);
      // return barcodeScanRes;
    } on PlatformException {
      barcodeScanRes = 'Failed to get platform version.';
    }
    // if (!mounted) return;
    // setState(() {
    //   _scanBarcode = barcodeScanRes;
    // });
    return barcodeScanRes;
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
                    future: Absensi(this.widget.session, {"TglAwal":selectedDate.toString().split(' ')[0], "TglAkhir":selectedDate.toString().split(' ')[0], "siswa_id": this.widget.session!.DataSiswa[0]["id"].toString() }).getAbsensi(), 
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
                                    snapshot.data!["data"][index]["NamaSiswa"] +" - " + snapshot.data!["data"][index]["NamaMataPelajaran"]
                                  ),
                                  subtitle: Text(
                                    snapshot.data!["data"][index]["FormatedAbsensiDate"]
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
      floatingActionButton: FloatingActionButton(
        child: Icon(Icons.add),
        onPressed: () async {
          var data = await barcodeScan().then((value) async {
            showLoadingDialog(context, _keyLoader, info: "Proses Absensi");
            Map oBarcodeParam(){
              return {
                "uuid" : value,
                "Tanggal" : selectedDate.toString().split(' ')[0]
              };
            }
            var barcodeObj = await Absensi(this.widget.session, oBarcodeParam()).cekbarcode().then((barcodeValue) async {
              Map oParamx() {
                return {
                  "jadwal_id"     : barcodeValue["data"]["jadwal_id"].toString(),
                  "TanggalAbsen"  : selectedDate.toString(),
                  "siswa_id"      : this.widget.session!.DataSiswa[0]["id"].toString(),
                  "barcode_id"    : value,
                  "CreatedBy"     : this.widget.session!.NamaUser,
                };
              }

              // print(oParamx());
              var oSave = await Absensi(this.widget.session, oParamx()).createAbsensi().then((value) {
                if (value["success"] == true) {
                  Navigator.of(context, rootNavigator: true).pop();
                  messageBox(context: context, title: "#Success", message: "Data berhasil disimpan");
                } else {
                  Navigator.of(context, rootNavigator: true).pop();
                  messageBox(context: context, title: "#Error", message: value["message"]);
                }
              });
            });

            
          });
        }
      )
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
