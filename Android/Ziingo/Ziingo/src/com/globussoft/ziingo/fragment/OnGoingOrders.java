package com.globussoft.ziingo.fragment;

import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.MainActivity;
import com.globussoft.ziingo.R;
//import com.jewelspark.fragments.NewNotification.FetchNotifications;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

public class OnGoingOrders extends Fragment{
	
	View rootview;
	
	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {
		rootview = inflater
				.inflate(R.layout.ongoingorders_viewpager , container, false);
		//InitView();

		if (ConstantUrl.isNetworkAvailable(getActivity())) {
			System.out.println("ongoing orders>>>>>>>>>>");
			//new FetchNotifications().execute();
		} else {
			MainActivity.MakeToast("Please check internet connection!!");

		}
		return rootview;
	}


}
