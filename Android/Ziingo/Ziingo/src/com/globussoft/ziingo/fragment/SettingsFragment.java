package com.globussoft.ziingo.fragment;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.RelativeLayout;

import com.globussoft.ziingo.R;

public class SettingsFragment extends Fragment {

	View rootView;

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {

		rootView = inflater.inflate(R.layout.fragment_settings, container,
				false);
		InitUI();
		return rootView;
	}

	private void InitUI() {
		// TODO Auto-generated method stub

	//	RelativeLayout rel1 = (RelativeLayout) rootView.findViewById(R.id.rel1);
		RelativeLayout rel2 = (RelativeLayout) rootView.findViewById(R.id.rel2);
		RelativeLayout rel3 = (RelativeLayout) rootView.findViewById(R.id.rel3);
		RelativeLayout rel4 = (RelativeLayout) rootView.findViewById(R.id.rel4);
		RelativeLayout rel5 = (RelativeLayout) rootView.findViewById(R.id.rel5);
		RelativeLayout rel6 = (RelativeLayout) rootView.findViewById(R.id.rel6);

		/*rel1.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

			}
		});*/

		rel2.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

			}
		});

		rel3.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

			}
		});

		rel4.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

			}
		});

		rel5.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

			}
		});

		rel6.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				Fragment fragment = new PrivacyPolicy();
				FragmentManager fmanager = getActivity()
						.getSupportFragmentManager();
				FragmentTransaction ftans = fmanager.beginTransaction();
				ftans.replace(R.id.frame_container, fragment);
				ftans.commit();

			}
		});

	}

}
