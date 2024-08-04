import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:absensimobile/shared/Session.dart';

class Auth {
  Session ? sess;
  Map? Parameter;

  Auth({this.sess,this.Parameter});

  Future<Map> Login() async{
    var url = Uri.parse("${sess!.server}login");
    final response = await http.post(url,body: Parameter);
    return json.decode(response.body);
  }

  Future<Map> gantiPassword() async{
    var url = Uri.parse("${sess!.server}changepass");
    final response = await http.post(url,body: Parameter);
    return json.decode(response.body);
  }
}
