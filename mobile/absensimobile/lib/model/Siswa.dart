import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:absensimobile/shared/Session.dart';

class Siswa {
  Session? sess;
  Map? Parameter;

  Siswa(this.sess, this.Parameter);

  Future<Map> getSiswa() async {
    var url = Uri.parse("${sess!.server}getsiswainfo");
    final response = await http.post(url, body: Parameter);
    return json.decode(response.body);
  }
}
