import 'dart:async';

import 'package:absensimobile/model/Jadwal.dart';
import 'package:absensimobile/shared/Session.dart';
import 'package:absensimobile/shared/dialog.dart';
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';

class ProfilePage extends StatefulWidget {
  Session? session;
  ProfilePage(this.session);

  @override
  _ProfilePageState createState() => _ProfilePageState();
}

class _ProfilePageState extends State<ProfilePage> {
  final GlobalKey<State> _keyLoader = new GlobalKey<State>();

  TextEditingController _NIS = TextEditingController();
  TextEditingController _NamaSiswa = TextEditingController();
  TextEditingController _Email = TextEditingController();
  TextEditingController _NoHP = TextEditingController();
  TextEditingController _TempatLahir = TextEditingController();
  TextEditingController _TanggalLahir = TextEditingController();
  TextEditingController _Kelas = TextEditingController();
  TextEditingController _TahunAjaran = TextEditingController();

  DateTime selectedDate = DateTime.now();

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
        _TanggalLahir.text = selectedDate.toString();
      });
  }

  @override
  void initState() {
    super.initState();
    _NIS.text = this.widget.session!.DataSiswa[0]["NIS"];
    _NamaSiswa.text = this.widget.session!.DataSiswa[0]["NamaSiswa"];
    _Email.text = this.widget.session!.DataSiswa[0]["Email"];
    _NoHP.text = this.widget.session!.DataSiswa[0]["Phone"];
    _TempatLahir.text = this.widget.session!.DataSiswa[0]["TempatLahir"];
    _TanggalLahir.text = this.widget.session!.DataSiswa[0]["TanggalLahir"];
    _Kelas.text = this.widget.session!.DataSiswa[0]["NamaKelas"];
    _TahunAjaran.text = this.widget.session!.DataSiswa[0]["TahunAjaran"];
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Theme.of(context).primaryColor,
        foregroundColor: Colors.white,
        title: Text("Profile"),
      ),
      body: Expanded(
        child: Column(
          children: [
            Padding(
              padding: EdgeInsets.only(
                top: this.widget.session!.width * 5,
                left: this.widget.session!.width * 2,
                right: this.widget.session!.width * 2
              ),
              child: TextField(
                controller: _NIS,
                decoration: InputDecoration(
                  labelText: 'NIS',
                  border: OutlineInputBorder(),
                  enabled: false,
                ),
                style: TextStyle(
                  color: Colors.black
                ),
              ),
            ),
            Padding(
              padding: EdgeInsets.only(
                top: this.widget.session!.width * 2,
                left: this.widget.session!.width * 2,
                right: this.widget.session!.width * 2
              ),
              child: TextField(
                controller: _NamaSiswa,
                decoration: InputDecoration(
                  labelText: 'Nama Siswa',
                  border: OutlineInputBorder(),
                  enabled: false
                ),
                style: TextStyle(
                  color: Colors.black
                ),
              ),
            ),
            Padding(
              padding: EdgeInsets.only(
                top: this.widget.session!.width * 2,
                left: this.widget.session!.width * 2,
                right: this.widget.session!.width * 2
              ),
              child: TextField(
                controller: _Email,
                decoration: InputDecoration(
                  labelText: 'Email',
                  border: OutlineInputBorder(),
                  enabled: false,
                  hintText: "aissystemsolo@gmail.com"
                ),
                style: TextStyle(
                  color: Colors.black
                ),
              ),
            ),
            Padding(
              padding: EdgeInsets.only(
                top: this.widget.session!.width * 2,
                left: this.widget.session!.width * 2,
                right: this.widget.session!.width * 2
              ),
              child: TextField(
                controller: _NoHP,
                decoration: InputDecoration(
                  labelText: 'Phone',
                  border: OutlineInputBorder(),
                  enabled: false,
                ),
                style: TextStyle(
                  color: Colors.black
                ),
              ),
            ),
            Padding(
              padding: EdgeInsets.only(
                top: this.widget.session!.width * 2,
                left: this.widget.session!.width * 2,
                right: this.widget.session!.width * 2
              ),
              child: TextField(
                controller: _TempatLahir,
                decoration: InputDecoration(
                  labelText: 'Tempat Lahir',
                  border: OutlineInputBorder(),
                  enabled: false,
                ),
                style: TextStyle(
                  color: Colors.black
                ),
              ),
            ),
            Padding(
              padding: EdgeInsets.only(
                top: this.widget.session!.width * 2,
                left: this.widget.session!.width * 2,
                right: this.widget.session!.width * 2
              ),
              child: TextField(
                controller: _TanggalLahir,
                decoration: InputDecoration(
                  labelText: 'Tanggal Lahir',
                  border: OutlineInputBorder(),
                  enabled: false,
                ),
                style: TextStyle(
                  color: Colors.black
                ),
              ),
            ),
            Padding(
              padding: EdgeInsets.only(
                top: this.widget.session!.width * 2,
                left: this.widget.session!.width * 2,
                right: this.widget.session!.width * 2
              ),
              child: TextField(
                controller: _Kelas,
                decoration: InputDecoration(
                  labelText: 'Kelas',
                  border: OutlineInputBorder(),
                  enabled: false,
                ),
                style: TextStyle(
                  color: Colors.black
                ),
              ),
            ),
            Padding(
              padding: EdgeInsets.only(
                top: this.widget.session!.width * 2,
                left: this.widget.session!.width * 2,
                right: this.widget.session!.width * 2
              ),
              child: TextField(
                controller: _TahunAjaran,
                decoration: InputDecoration(
                  labelText: 'Tahun Ajaran',
                  border: OutlineInputBorder(),
                  enabled: false,
                ),
                style: TextStyle(
                  color: Colors.black
                ),
              ),
            )
          ],
        )
      )
    );
  }
}
