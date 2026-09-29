import 'package:flutter/material.dart';
import '../theme/app_colors.dart';

class EmptyState extends StatelessWidget {
  final String message;
  final IconData icon;
  const EmptyState({super.key, required this.message, this.icon = Icons.inbox_outlined});
  @override
  Widget build(BuildContext context) => Center(child: Column(
      mainAxisAlignment: MainAxisAlignment.center, children: [
        Icon(icon, size: 56, color: AppColors.light),
        const SizedBox(height: 12),
        Text(message, style: const TextStyle(color: AppColors.textGray)),
      ]));
}
