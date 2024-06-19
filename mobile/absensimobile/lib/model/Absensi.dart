import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:absensimobile/shared/Session.dart';

class Absensi {
  Session? sess;
  Map? Parameter;

  Absensi(this.sess, this.Parameter);

  Future<Map> getAbsensi() async {
    var url = Uri.parse("${sess!.server}readreviewabsen");
    print(Parameter);
    final response = await http.post(url, body: Parameter);
    return json.decode(response.body);
  }

  Future<Map> createAbsensi() async {
    var url = Uri.parse("${sess!.server}insertabsen");
    final response = await http.post(url, body: Parameter);
    return json.decode(response.body);
  }

  Future<Map> cekbarcode() async {
    var url = Uri.parse("${sess!.server}checkbarcode");
    final response = await http.post(url, body: Parameter);
    return json.decode(response.body);
  }

  Future<Map> getDashbiard() async {
    var url = Uri.parse("${sess!.server}dashboardabsen");
    final response = await http.post(url, body: Parameter);
    return json.decode(response.body);
  }
}
