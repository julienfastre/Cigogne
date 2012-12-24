package org.fastre.cigogne.client;

import org.fastre.cigogne.client.mvp.AppActivityMapper;
import org.fastre.cigogne.client.mvp.AppPlaceHistoryMapper;
import org.fastre.cigogne.client.place.HomePagePlace;
import com.google.gwt.activity.shared.ActivityMapper;
import com.google.gwt.activity.shared.ActivityManager;
import com.google.gwt.core.client.EntryPoint;
import com.google.gwt.core.shared.GWT;
import com.google.gwt.event.shared.HandlerManager;
import com.google.gwt.place.shared.Place;
import com.google.gwt.place.shared.PlaceController;
import com.google.gwt.place.shared.PlaceHistoryHandler;
import com.google.gwt.user.client.Window;
import com.google.gwt.user.client.ui.RootPanel;
import com.google.gwt.user.client.ui.SimplePanel;
import com.google.web.bindery.event.shared.EventBus;

public class CigogneEntryPoint implements EntryPoint {
	
	private SimplePanel appWidget = new SimplePanel();
	private Place defaultPlace = new HomePagePlace();

	public void onModuleLoad() {
		ClientFactory clientFactory = new ClientFactory();
		EventBus eventBus = clientFactory.getEventBus();
		PlaceController placeController = clientFactory.getPlaceController();
		
		ActivityMapper activityMapper = new AppActivityMapper(clientFactory);
		ActivityManager activityManager = new ActivityManager(activityMapper, eventBus);
		activityManager.setDisplay(appWidget);
		
		AppPlaceHistoryMapper historyMapper = GWT.create(AppPlaceHistoryMapper.class);
		PlaceHistoryHandler historyHandler = new PlaceHistoryHandler(historyMapper);
		historyHandler.register(placeController, eventBus, defaultPlace);
		
		RootPanel.get("panel").add(appWidget);
		historyHandler.handleCurrentHistory();
		
		
		
	}

}
