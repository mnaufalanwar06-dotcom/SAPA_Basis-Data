import 'package:flutter/material.dart';
import 'theme.dart';
import 'home.dart';
import 'riwayat.dart';
import 'profil.dart';

class NavbarPage extends StatefulWidget {
  final int initialIndex;
  const NavbarPage({super.key, this.initialIndex = 0});

  @override
  State<NavbarPage> createState() => _NavbarPageState();
}

class _NavbarPageState extends State<NavbarPage> {
  late int _index;

  @override
  void initState() {
    super.initState();
    _index = widget.initialIndex;
  }

  @override
  Widget build(BuildContext context) {
    Widget content;
    if (_index == 0) {
      content = HomePage(onTabChange: (i) => setState(() => _index = i));
    } else if (_index == 1) {
      content = const RiwayatPage();
    } else {
      content = const ProfilPage();
    }

    return Scaffold(
      body: content,
      bottomNavigationBar: Container(
        height: 68,
        decoration: const BoxDecoration(
          color: AppTheme.headerPink,
          borderRadius: BorderRadius.only(
            topLeft: Radius.circular(26),
            topRight: Radius.circular(26),
          ),
        ),
        child: Row(
          mainAxisAlignment: MainAxisAlignment.spaceAround,
          children: [
            IconButton(
              icon: Icon(Icons.home, color: _index == 0 ? Colors.white : Colors.white60, size: 28),
              onPressed: () => setState(() => _index = 0),
            ),
            IconButton(
              icon: Icon(Icons.description_outlined, color: _index == 1 ? Colors.white : Colors.white60, size: 26),
              onPressed: () => setState(() => _index = 1),
            ),
            IconButton(
              icon: Icon(Icons.person_outline, color: _index == 2 ? Colors.white : Colors.white60, size: 26),
              onPressed: () => setState(() => _index = 2),
            ),
          ],
        ),
      ),
    );
  }
}